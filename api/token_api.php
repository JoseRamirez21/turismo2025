<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../models/TokenModel.php';

$tokenModel = new TokenModel();

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
    if ($tokenModel->validarToken($token)) {
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
    $tokens = $tokenModel->obtenerTokensActivos();
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

