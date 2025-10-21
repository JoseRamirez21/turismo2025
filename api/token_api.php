<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../models/TokensApi.php'; // ✅ nombre correcto
require_once __DIR__ . '/../config/config.php';    // ✅ para usar $pdo

$tokenModel = new TokensApi($pdo); // ✅ clase correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir token enviado (para validar)
    $token = $_POST['token'] ?? '';


    if (empty($token)) {
        echo json_encode([
            'status' => 'warning',
            'message' => '⚠️ Debes enviar un token para validar.'
        ]);
        exit;
    }

    // Validar token
    $resultado = $tokenModel->validarToken($token);

    if (!empty($resultado['success']) && $resultado['success'] === true) {
        echo json_encode([
            'status' => 'success',
            'message' => '✅ Token válido y activo.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Token inválido o inactivo.'
        ]);
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Opcional: devolver todos los tokens activos (solo para pruebas)
    $tokens = $tokenModel->getAll();
    echo json_encode([
        'status' => 'success',
        'data' => $tokens
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido. Use POST o GET.'
    ]);
}
