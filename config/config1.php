<?php
// =========================================
// CONFIGURACIÓN GLOBAL DEL SISTEMA
// =========================================

// Nombre del sistema
define('APP_NAME', 'Turismo Perú SAC');

// BASE_URL de tu aplicación
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
$projectFolder = ''; // 🔧 En hosting generalmente vacío
define('BASE_URL', $scheme . '://' . $host . $projectFolder);

// =========================================
// CONFIGURACIÓN DE APIs (completar cuando estén listas)
// =========================================

// Ejemplo: define('API_BASE_URL', 'https://api.tudominio.com');
define('API_BASE_URL', ''); // 🔧 dejar vacío hasta tener API lista

// =========================================
// HELPERS
// =========================================

/**
 * Genera la URL completa para un asset (css, js, img).
 */
function asset(string $path): string {
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Devuelve la ruta absoluta a una vista o componente.
 */
function view_path(string $relative): string {
    return __DIR__ . '/../' . ltrim($relative, '/');
}

// =========================================
// CONEXIÓN A BASE DE DATOS
// =========================================

class Database {
    // 🔧 Completar en hosting
    private string $host     = ""; 
    private string $dbname   = "";
    private string $username = "";
    private string $password = "";

    private ?PDO $conn = null;

    public function getConnection(): ?PDO {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
                $this->conn = new PDO($dsn, $this->username, $this->password, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die("❌ Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}

// Conexión global (lista para usar en tus modelos/controladores)
$db  = new Database();
$pdo = $db->getConnection();
