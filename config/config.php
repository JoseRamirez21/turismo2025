<?php
// =========================================
// CONFIGURACIÓN GLOBAL DEL SISTEMA
// =========================================

// Nombre del sistema
define('APP_NAME', 'Turismo Perú SAC');

// BASE_URL para XAMPP
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Cambia esto por la carpeta de tu proyecto en htdocs
$projectFolder = '/turismo2025';
define('BASE_URL', $scheme . '://' . $host . $projectFolder);

// URL de la API (para hosting)
define('API_BASE_URL', 'https://api.tudominio.com'); // 🔧 cambiar para hosting

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
    private string $host     = "localhost";
    private string $dbname   = "turismo_peru";
    private string $username = "root";
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
                die("❌ Error de conexión a la base de datos '{$this->dbname}': " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}

// Conexión global lista
$db  = new Database();
$pdo = $db->getConnection();
