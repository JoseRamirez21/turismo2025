<?php
// models/Provincia.php
require_once __DIR__ . '/../config/config.php';

class Provincia {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Obtener provincias por departamento_id
    public function getByDepartamento(int $departamentoId): array {
        $stmt = $this->pdo->prepare("SELECT id_provincia, nombre FROM provincias WHERE id_departamento = ? ORDER BY nombre ASC");
        $stmt->execute([$departamentoId]);
        return $stmt->fetchAll();
    }

    // Obtener una provincia por ID
   public function getById(int $id_provincia): ?array {
    $stmt = $this->pdo->prepare("SELECT id_provincia, nombre FROM provincias WHERE id_provincia = ?");
    $stmt->execute([$id_provincia]);
    $result = $stmt->fetch();
    return $result ?: null;
}

}
