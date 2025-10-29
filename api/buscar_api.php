<?php
require_once __DIR__ . '/../config/config.php';  // Configuración con PDO
require_once __DIR__ . '/../models/Lugar_api.php';  // Modelo de búsqueda
require_once __DIR__ . '/../controllers/BuscarApiController.php'; // Controlador

// Verificar que el método de solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
