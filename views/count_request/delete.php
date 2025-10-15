<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/CountRequestController.php';

if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$controller = new CountRequestController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

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
    header('Location: index.php');
    exit;
}
