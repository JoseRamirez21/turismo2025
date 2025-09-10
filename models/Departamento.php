<?php
// models/Departamento.php
require_once __DIR__ . '/../config/config.php';

class Departamento {
    private $pdo;

    public function __construct() {
        global $pdo; // usamos la conexión de config.php
        $this->pdo = $pdo;
    }

    // 🔹 Obtener todos los departamentos con búsqueda, límite y offset
    public function getAll(string $search = '', int $limit = 20, int $offset = 0): array {
        $sql = "SELECT id_departamento, nombre 
                FROM departamentos
                WHERE nombre LIKE :search
                ORDER BY nombre ASC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Contar departamentos (para paginación y búsqueda)
    public function count(string $search = ''): int {
        $sql = "SELECT COUNT(*) FROM departamentos WHERE nombre LIKE :search";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
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

