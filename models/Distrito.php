<?php
// models/Distrito.php
require_once __DIR__ . '/../config/config.php';

class Distrito {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Obtener todos los distritos con búsqueda, límite y offset
    public function getAll(string $search = '', int $limit = 20, int $offset = 0): array {
        $sql = "SELECT d.id_distrito, d.nombre, 
                       p.nombre AS provincia_nombre,
                       dep.nombre AS departamento_nombre
                FROM distritos d
                INNER JOIN provincias p ON d.id_provincia = p.id_provincia
                INNER JOIN departamentos dep ON p.id_departamento = dep.id_departamento
                WHERE d.nombre LIKE :search
                ORDER BY d.id_distrito ASC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $searchTerm = "%$search%";
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Contar distritos para paginación
    public function count(string $search = ''): int {
        $sql = "SELECT COUNT(*) as total
                FROM distritos d
                INNER JOIN provincias p ON d.id_provincia = p.id_provincia
                INNER JOIN departamentos dep ON p.id_departamento = dep.id_departamento
                WHERE d.nombre LIKE :search";
        $stmt = $this->pdo->prepare($sql);
        $searchTerm = "%$search%";
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $row['total'];
    }

    // Obtener distritos por provincia
    public function getByProvincia(int $provinciaId): array {
        $stmt = $this->pdo->prepare("SELECT id_distrito, nombre FROM distritos WHERE id_provincia = ? ORDER BY nombre ASC");
        $stmt->execute([$provinciaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un distrito por ID
    public function getById(int $id_distrito): ?array {
        $stmt = $this->pdo->prepare("SELECT id_distrito, nombre, id_provincia FROM distritos WHERE id_distrito = ?");
        $stmt->execute([$id_distrito]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // Crear distrito
    public function create(int $id_provincia, string $nombre): bool {
        $stmt = $this->pdo->prepare("INSERT INTO distritos (id_provincia, nombre) VALUES (?, ?)");
        return $stmt->execute([$id_provincia, $nombre]);
    }

    // Actualizar distrito
    public function update(int $id_distrito, int $id_provincia, string $nombre): bool {
        $stmt = $this->pdo->prepare("UPDATE distritos SET id_provincia = ?, nombre = ? WHERE id_distrito = ?");
        return $stmt->execute([$id_provincia, $nombre, $id_distrito]);
    }

    // Eliminar distrito
    public function delete(int $id_distrito): bool {
        $stmt = $this->pdo->prepare("DELETE FROM distritos WHERE id_distrito = ?");
        return $stmt->execute([$id_distrito]);
    }
    // Obtener distrito con información completa (provincia y departamento)
public function getByIdFull(int $id_distrito): ?array {
    $stmt = $this->pdo->prepare("
        SELECT d.id_distrito, d.nombre AS distrito_nombre,
               p.id_provincia, p.nombre AS provincia_nombre,
               dp.id_departamento, dp.nombre AS departamento_nombre
        FROM distritos d
        INNER JOIN provincias p ON d.id_provincia = p.id_provincia
        INNER JOIN departamentos dp ON p.id_departamento = dp.id_departamento
        WHERE d.id_distrito = ?
    ");
    $stmt->execute([$id_distrito]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ?: null;
}

}
