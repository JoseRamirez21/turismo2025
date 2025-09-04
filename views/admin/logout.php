<?php
// views/admin/logout.php
require_once __DIR__ . '/../../config/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destruir todas las variables de sesión relacionadas al admin
unset($_SESSION['admin_id']);
unset($_SESSION['admin_nombre']);

// Opcional: destruir toda la sesión
// session_destroy();

// Redirigir al login o al inicio
header("Location: " . BASE_URL . "/views/admin/login.php");
exit;
