<?php
// models/Lugar.php
require_once __DIR__ . '/../config/config.php';

class Lugar {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // 🔹 Listar todos con búsqueda, límite y offset
    public function getAll(int $limit = 20, int $offset = 0, string $search = ''): array {
        $sql = "
            SELECT l.id_lugar, l.nombre, l.tipo, d.nombre AS distrito_nombre
            FROM lugares_turisticos l
            LEFT JOIN distritos d ON l.id_distrito = d.id_distrito
        ";

        if (!empty($search)) {
            $sql .= " WHERE l.nombre LIKE :search ";
        }

        $sql .= " ORDER BY l.id_lugar ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        if (!empty($search)) {
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Contar registros para paginación
    public function count(string $search = ''): int {
        $sql = "SELECT COUNT(*) as total FROM lugares_turisticos";
        if (!empty($search)) {
            $sql .= " WHERE nombre LIKE :search";
        }
        $stmt = $this->pdo->prepare($sql);
        if (!empty($search)) {
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $row['total'];
    }

    // 🔹 Obtener lugares por distrito
    public function getByDistrito(int $id_distrito): array {
        $stmt = $this->pdo->prepare("SELECT * FROM lugares_turisticos WHERE id_distrito = ?");
        $stmt->execute([$id_distrito]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Crear
    public function create(array $data): bool {
        $stmt = $this->pdo->prepare("INSERT INTO lugares_turisticos (nombre, tipo, id_distrito) VALUES (?, ?, ?)");
        return $stmt->execute([$data['nombre'], $data['tipo'], $data['id_distrito']]);
    }

    // 🔹 Obtener por ID
    public function getById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM lugares_turisticos WHERE id_lugar = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    // 🔹 Actualizar
    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare("UPDATE lugares_turisticos SET nombre = ?, tipo = ?, id_distrito = ? WHERE id_lugar = ?");
        return $stmt->execute([$data['nombre'], $data['tipo'], $data['id_distrito'], $id]);
    }

    // 🔹 Eliminar
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM lugares_turisticos WHERE id_lugar = ?");
        return $stmt->execute([$id]);
    }
}
