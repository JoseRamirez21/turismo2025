<?php
// models/Provincia.php
require_once __DIR__ . '/../config/config.php';

class Provincia {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // 🔹 Obtener todas las provincias con su departamento
public function getAll(): array {
    $sql = "SELECT p.id_provincia, p.nombre, d.nombre AS departamento_nombre
            FROM provincias p
            INNER JOIN departamentos d ON p.id_departamento = d.id_departamento
            ORDER BY d.nombre ASC, p.nombre ASC";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
}


    // 🔹 Obtener provincias por departamento_id
    public function getByDepartamento(int $departamentoId): array {
        $stmt = $this->pdo->prepare("SELECT id_provincia, nombre 
                                     FROM provincias 
                                     WHERE id_departamento = ? 
                                     ORDER BY nombre ASC");
        $stmt->execute([$departamentoId]);
        return $stmt->fetchAll();
    }

    // 🔹 Obtener una provincia por ID
    public function getById(int $id_provincia): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM provincias WHERE id_provincia = ?");
        $stmt->execute([$id_provincia]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // 🔹 Crear provincia
    public function create(string $nombre, int $id_departamento): bool {
        $stmt = $this->pdo->prepare("INSERT INTO provincias (nombre, id_departamento) VALUES (?, ?)");
        return $stmt->execute([$nombre, $id_departamento]);
    }

    // 🔹 Actualizar provincia
    public function update(int $id_provincia, string $nombre, int $id_departamento): bool {
        $stmt = $this->pdo->prepare("UPDATE provincias SET nombre = ?, id_departamento = ? WHERE id_provincia = ?");
        return $stmt->execute([$nombre, $id_departamento, $id_provincia]);
    }

    // 🔹 Eliminar provincia
    public function delete(int $id_provincia): bool {
        $stmt = $this->pdo->prepare("DELETE FROM provincias WHERE id_provincia = ?");
        return $stmt->execute([$id_provincia]);
    }
    
}
