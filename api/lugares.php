<?php
// api/lugares.php
// Devuelve JSON con los lugares turísticos (soporta search, limit, page).
// Requiere TokenModel para validar token (si quieres proteger el endpoint).

// Cabeceras
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Ajustes de error para desarrollo (quita en producción)
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Rutas a tus modelos/controladores
require_once __DIR__ . '/../models/TokenModel.php';
require_once __DIR__ . '/../controllers/LugarController.php';

// Leer parámetros (GET)
$token  = $_GET['token']  ?? '';           // opcional si quieres validar
$search = $_GET['search'] ?? '';
$limit  = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Si quieres forzar token obligatorio, descomenta las líneas de validación abajo:
$tokenModel = new TokenModel();
if (empty($token) || !$tokenModel->validarToken(trim($token))) {
    // Si quieres permitir acceso público, comenta/borra este bloque.
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Token inválido o inactivo.'
    ]);
    exit;
}

// Instanciar controller y obtener datos
$lugarController = new LugarController();

// Suponiendo que LugarController::index($limit, $offset, $search) devuelve array de lugares
try {
    $lugares = $lugarController->index($limit, $offset, $search);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Error en servidor: ' . $e->getMessage()
    ]);
    exit;
}

// Contar total (si el controller tiene método count)
$total = 0;
if (method_exists($lugarController, 'count')) {
    $total = (int) $lugarController->count($search);
}

// Respuesta
echo json_encode([
    'status' => 'success',
    'message' => '✅ Lugares obtenidos.',
    'meta' => [
        'total' => $total,
        'page'  => $page,
        'limit' => $limit,
    ],
    'data' => $lugares,
], JSON_UNESCAPED_UNICODE);
exit;
