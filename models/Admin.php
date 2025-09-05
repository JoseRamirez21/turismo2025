<?php
// models/Admin.php
require_once __DIR__ . '/../config/config.php';

class Admin {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Método para iniciar sesión con email y password
   public function login(string $email, string $clave): ?array {
    $stmt = $this->pdo->prepare("SELECT id_admin, nombre, email, password FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // Debug temporal
    if (!$admin) {
        die("⚠️ No se encontró usuario con email: $email");
    }

    if (!password_verify($clave, $admin['password'])) {
        die("⚠️ Contraseña incorrecta para $email. Hash guardado: {$admin['password']}, ingresada: $clave");
    }

    return $admin;
}

}
