<?php
require_once __DIR__ . '/../config/config.php';  // Configuración con PDO
require_once __DIR__ . '/../models/Lugar_api.php';  // Modelo de búsqueda
require_once __DIR__ . '/../controllers/BuscarApiController.php'; // Controlador

// Verificar que el método de solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el token desde el cuerpo de la solicitud (JSON)
    $input = json_decode(file_get_contents('php://input'), true);
    $token = isset($input['token']) ? trim($input['token']) : '';

    // Verificar si el token está presente
    if (empty($token)) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Token no proporcionado.'
        ]);
        exit;
    }

    // ============================
    // Validar token en sistema principal
    // ============================
    $stmt = $pdo->prepare("SELECT * FROM tokens_api WHERE token = :token");
    $stmt->execute(['token' => $token]);
    $tokenPrinc = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tokenPrinc) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Token no válido en el sistema principal.'
        ]);
        exit;
    }

    if ($tokenPrinc['estado'] != 1) {
        echo json_encode([
            'status' => 'error',
            'message' => '⚠️ Token inactivo en el sistema principal.'
        ]);
        exit;
    }

    // ============================
    // Token válido → proceder con la búsqueda
    // ============================
    $controller = new BuscarApiController($pdo); // usar la conexión principal
    $controller->buscar();

} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Método no permitido. Use POST para realizar la búsqueda.'
    ]);
    exit;
}
