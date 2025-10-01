<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/TokensApiController.php';

// Verificar sesión de admin
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$controller = new TokensApiController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    // Validar que el ID sea numérico y no esté vacío
    if (!empty($id) && ctype_digit($id)) {
        $deleted = $controller->destroy((int)$id);

        if ($deleted) {
            header('Location: index.php?deleted=1');
            exit;
        } else {
            header('Location: index.php?error=1');
            exit;
        }
    } else {
        header('Location: index.php?error=1');
        exit;
    }
} else {
    // Si entran directamente sin POST, redirigir
    header('Location: index.php');
    exit;
}
