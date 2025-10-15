<?php
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/TokensApiController.php';

header('Content-Type: application/json');

$controller = new TokensApiController($pdo);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtener todos o por ID
        if (isset($_GET['id'])) {
       echo json_encode($controller->getTokenById($_GET['id']));
        } else {
            echo json_encode($controller->index());
        }
        break;

    case 'POST':
        // 🔹 Capturamos los datos, puede venir desde JSON o desde un formulario HTML
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            $data = $_POST;
        }

        // 🔹 Si se solicita VALIDAR TOKEN
        if (isset($data['accion']) && $data['accion'] === 'validar_token') {
            $token = trim($data['token'] ?? '');

            if (empty($token)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Token no proporcionado'
                ]);
                break;
            }

            // Llamamos al nuevo método validarToken() del controlador
            $resultado = $controller->validarToken($token);
            echo json_encode($resultado);
            break;
        }

        // 🔹 Crear token normal (ya existente)
        echo json_encode(['success' => $controller->create($data)]);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'] ?? null;
        echo json_encode(['success' => $controller->update($id, $data)]);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        echo json_encode(['success' => $controller->destroy($id)]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}

$tokenModel = new TokensApi($pdo);

header('Content-Type: application/json');

if ($_GET['action'] === 'validate') {
    $token = $_POST['token'] ?? '';

    $resultado = $tokenModel->validarToken($token);

    if ($resultado['success']) {
        echo json_encode(['status' => 'success', 'message' => 'Token válido']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Token inválido o no encontrado']);
    }
}
