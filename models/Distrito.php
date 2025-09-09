<?php
// models/Distrito.php
require_once __DIR__ . '/../config/config.php';

class Distrito {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Obtener todos los distritos con provincia y departamento
    public function getAll(): array {
        $sql = "SELECT d.id_distrito, d.nombre, 
                       p.nombre AS provincia_nombre,
                       dep.nombre AS departamento_nombre
                FROM distritos d
                INNER JOIN provincias p ON d.id_provincia = p.id_provincia
                INNER JOIN departamentos dep ON p.id_departamento = dep.id_departamento
                ORDER BY dep.nombre ASC, p.nombre ASC, d.nombre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // Obtener distritos por provincia
    public function getByProvincia(int $provinciaId): array {
        $stmt = $this->pdo->prepare("SELECT id_distrito, nombre FROM distritos WHERE id_provincia = ? ORDER BY nombre ASC");
        $stmt->execute([$provinciaId]);
        return $stmt->fetchAll();
    }

    // Obtener un distrito por ID
    public function getById(int $id_distrito): ?array {
        $stmt = $this->pdo->prepare("SELECT id_distrito, nombre, id_provincia FROM distritos WHERE id_distrito = ?");
        $stmt->execute([$id_distrito]);
        $result = $stmt->fetch();
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
}
