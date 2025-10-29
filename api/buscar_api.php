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

    // Verificar si el token está activo en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM tokens_api WHERE token = :token AND estado = 1");
    $stmt->execute(['token' => $token]);
    $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra el token o no está activo, retornar error
    if (!$tokenData) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Token no válido o inactivo.'
        ]);
        exit;
    }

    // Crear una instancia del controlador, pasando la conexión PDO
    $controller = new BuscarApiController($pdo);
    // Llamar al método 'buscar' para procesar la solicitud
    $controller->buscar();
} else {
    echo json_encode([  // Si no es POST, retornar un error
        'status' => 'error',
        'message' => '❌ Método no permitido. Use POST para realizar la búsqueda.'
    ]);
    exit;
}
?>
