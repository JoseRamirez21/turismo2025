<?php
// /api/client.php
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/ClientApiController.php';

header('Content-Type: application/json; charset=utf-8');

$controller = new ClientApiController($pdo);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $data = $controller->getById($_GET['id']);
        } else {
            $data = $controller->index();
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $result = $controller->create($input);
        echo json_encode(['success' => $result]);
        break;

    case 'PUT':
        $id = $_GET['id'] ?? null;
        $input = json_decode(file_get_contents('php://input'), true);
        $result = $controller->update($id, $input);
        echo json_encode(['success' => $result]);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        $result = $controller->destroy($id);
        echo json_encode(['success' => $result]);
        break;
}
