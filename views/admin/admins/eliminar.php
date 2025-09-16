<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/AdminController.php';

$controller = new AdminController();

$errors = [];
$msg = '';

// Verificar que se envió el ID por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id && is_numeric($id)) {
        if ($controller->delete((int)$id)) {
            // Redirigir con mensaje de éxito
            header("Location: listar.php?msg=Administrador eliminado correctamente");
            exit;
        } else {
            // Redirigir con mensaje de error
            header("Location: listar.php?error=Error al eliminar el administrador");
            exit;
        }
    } else {
        header("Location: listar.php?error=ID inválido");
        exit;
    }
} else {
    // Si no es POST, redirigir al listado
    header("Location: listar.php");
    exit;
}
