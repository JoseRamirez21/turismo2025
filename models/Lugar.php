<?php
// models/Lugar.php
require_once __DIR__ . '/../config/config.php';

class Lugar {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // 🔹 Obtener todos los lugares
    public function getAll(): array {
        $sql = "
            SELECT l.id_lugar, l.nombre, l.descripcion, l.tipo, l.latitud, l.longitud,
                   l.id_distrito, d.nombre AS distrito_nombre
            FROM lugares_turisticos l
            LEFT JOIN distritos d ON l.id_distrito = d.id_distrito
            ORDER BY l.nombre ASC
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // 🔹 Obtener lugares por distrito_id
    public function getByDistrito(int $id_distrito): array {
        $stmt = $this->pdo->prepare("
            SELECT id_lugar, nombre, descripcion, tipo, latitud, longitud, id_distrito
            FROM lugares_turisticos
            WHERE id_distrito = ?
            ORDER BY nombre ASC
        ");
        $stmt->execute([$id_distrito]);
        return $stmt->fetchAll();
    }

    // 🔹 Obtener un lugar por ID
    public function getById(int $id_lugar): ?array {
        $stmt = $this->pdo->prepare("
            SELECT id_lugar, nombre, descripcion, tipo, latitud, longitud, id_distrito
            FROM lugares_turisticos
            WHERE id_lugar = ?
        ");
        $stmt->execute([$id_lugar]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // 🔹 Crear un nuevo lugar
    public function create(array $data): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO lugares_turisticos (nombre, descripcion, tipo, latitud, longitud, id_distrito)
            VALUES (:nombre, :descripcion, :tipo, :latitud, :longitud, :id_distrito)
        ");
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':tipo' => $data['tipo'],
            ':latitud' => $data['latitud'],
            ':longitud' => $data['longitud'],
            ':id_distrito' => $data['id_distrito']
        ]);
    }

    // 🔹 Actualizar un lugar
    public function update(int $id_lugar, array $data): bool {
        $stmt = $this->pdo->prepare("
            UPDATE lugares_turisticos
            SET nombre = :nombre,
                descripcion = :descripcion,
                tipo = :tipo,
                latitud = :latitud,
                longitud = :longitud,
                id_distrito = :id_distrito
            WHERE id_lugar = :id_lugar
        ");
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':tipo' => $data['tipo'],
            ':latitud' => $data['latitud'],
            ':longitud' => $data['longitud'],
            ':id_distrito' => $data['id_distrito'],
            ':id_lugar' => $id_lugar
        ]);
    }

    // 🔹 Eliminar un lugar
    public function delete(int $id_lugar): bool {
        $stmt = $this->pdo->prepare("DELETE FROM lugares_turisticos WHERE id_lugar = ?");
        return $stmt->execute([$id_lugar]);
    }
}
