<?php
// models/Admin.php
require_once __DIR__ . '/../config/config.php';

class Admin {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Método para iniciar sesión
    public function login(string $usuario, string $clave): ?array {
        $stmt = $this->pdo->prepare("SELECT id_admin, nombre, usuario, clave FROM admins WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($clave, $admin['clave'])) {
            // Si la contraseña es correcta
            return $admin;
        }

        return null; // Usuario o contraseña incorrectos
    }

    // Otros métodos CRUD para administrar los lugares pueden ir aquí
}
