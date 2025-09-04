<?php
// models/Departamento.php
require_once __DIR__ . '/../config/config.php';

class Departamento {
    private $pdo;

    public function __construct() {
        global $pdo; // usamos la conexión de config.php
        $this->pdo = $pdo;
    }

    // Obtener todos los departamentos
    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT id_departamento, nombre FROM departamentos ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    // Obtener un departamento por ID
   public function getById(int $id_departamento): ?array {
    $stmt = $this->pdo->prepare("SELECT id_departamento, nombre FROM departamentos WHERE id_departamento = ?");
    $stmt->execute([$id_departamento]);
    $result = $stmt->fetch();
    return $result ?: null;
}

}
