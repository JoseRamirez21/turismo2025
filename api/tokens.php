<?php
require_once __DIR__ . '/../config/cors.php';  //permite peticiones desde el navegador
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/TokensApiController.php';
require_once __DIR__ . '/../models/TokensApi.php';

session_start();
header('Content-Type: application/json; charset=utf-8'); //Definir que la respuesta sea JSON

// Instancias
$controller = new TokensApiController($pdo);
$tokenModel = new TokensApi($pdo);


if (isset($_GET['action']) && $_GET['action'] === 'validate') {  //Validacion de TOKEN
    // Recibir el token desde el cuerpo JSON
    $input = json_decode(file_get_contents('php://input'), true);
    $token = trim($input['token'] ?? '');

    if (empty($token)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Token no proporcionado'
        ]);
        exit;
    }

    // Consultar en la BD
    $resultado = $tokenModel->validarToken($token);

    if (!empty($resultado['success']) && $resultado['success'] === true) {
        //  Guardar sesión del admin para ingresar por token
        $_SESSION['admin_autenticado'] = true;
        $_SESSION['token'] = $token;
        $_SESSION['id_token'] = $resultado['data']['id'] ?? null;

        echo json_encode([
            'status' => 'success',
            'message' => 'Token válido',
            'data' => $resultado['data'] ?? null
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Token inválido o expirado'
        ]);
    }
    exit;
}

//CRUD completo 

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':                                                                         //Consulta información
        if (isset($_GET['id'])) {
            echo json_encode($controller->getTokenById($_GET['id']));
        } else {
            echo json_encode($controller->index());
        }
        break;

    case 'POST':                                                                    //Crear o envia información
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) $data = $_POST;

        if (isset($data['accion']) && $data['accion'] === 'validar_token') {
            $token = trim($data['token'] ?? '');
            if (empty($token)) {
                echo json_encode(['success' => false, 'message' => 'Token no proporcionado']);
                break;
            }
            $resultado = $controller->validarToken($token);
            echo json_encode($resultado);
            break;
        }

        echo json_encode(['success' => $controller->create($data)]);
        break;

    case 'PUT':                                                                 //Actualiza un registro
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'] ?? null;
        echo json_encode(['success' => $controller->update($id, $data)]);
        break;

    case 'DELETE':                                                            //Elimina algo
        $id = $_GET['id'] ?? null;
        echo json_encode(['success' => $controller->destroy($id)]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}
