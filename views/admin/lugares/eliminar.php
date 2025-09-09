<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/LugarController.php';

$controller = new LugarController();

// Obtener ID del lugar turístico desde GET
$id = $_GET['id'] ?? null;

// Validar que sea un número
if ($id && is_numeric($id)) {
    // Llamar al método destroy del controlador
    if ($controller->destroy((int)$id)) {
        // Redirigir al listado con mensaje de éxito
        header("Location: listar.php?msg=Lugar turístico eliminado correctamente");
        exit;
    } else {
        // Redirigir con mensaje de error
        header("Location: listar.php?error=Error al eliminar el lugar turístico");
        exit;
    }
} else {
    // Redirigir con mensaje si el ID no es válido
    header("Location: listar.php?error=ID inválido");
    exit;
}
