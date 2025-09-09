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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un departamento por ID
    public function getById(int $id_departamento): ?array {
        $stmt = $this->pdo->prepare("SELECT id_departamento, nombre FROM departamentos WHERE id_departamento = ?");
        $stmt->execute([$id_departamento]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // Crear un nuevo departamento
    public function create(string $nombre): bool {
        $stmt = $this->pdo->prepare("INSERT INTO departamentos (nombre) VALUES (?)");
        return $stmt->execute([$nombre]);
    }

    // Actualizar un departamento
    public function update(int $id_departamento, string $nombre): bool {
        $stmt = $this->pdo->prepare("UPDATE departamentos SET nombre = ? WHERE id_departamento = ?");
        return $stmt->execute([$nombre, $id_departamento]);
    }

    // Eliminar un departamento
    public function delete(int $id_departamento): bool {
        $stmt = $this->pdo->prepare("DELETE FROM departamentos WHERE id_departamento = ?");
        return $stmt->execute([$id_departamento]);
    }
    
}
