<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../models/Provincia.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el admin esté logueado
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$provinciaModel = new Provincia();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    if ($id > 0) {
        if ($provinciaModel->delete($id)) {
            $_SESSION['success'] = "✅ Provincia eliminada correctamente.";
        } else {
            $_SESSION['error'] = "❌ No se pudo eliminar la provincia.";
        }
    } else {
        $_SESSION['error'] = "⚠️ ID inválido.";
    }

    header("Location: listar.php");
    exit;
} else {
    header("Location: listar.php");
    exit;
}
