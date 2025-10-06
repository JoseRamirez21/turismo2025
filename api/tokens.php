<?php
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/TokensApiController.php';

header('Content-Type: application/json');

$controller = new TokensApiController($pdo);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo json_encode($controller->getById($_GET['id']));
        } else {
            echo json_encode($controller->index());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
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
