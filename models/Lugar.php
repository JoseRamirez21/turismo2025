<?php
// models/Lugar.php
require_once __DIR__ . '/../config/config.php';

class Lugar {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Obtener todos los lugares por distrito_id
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


    // Obtener un lugar por su ID (para detalle)
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
// Agregar un nuevo lugar
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



// models/Lugar.php
public function getAll(): array {
    $stmt = $this->pdo->query("
        SELECT l.id_lugar, l.nombre, l.tipo, l.id_distrito, d.nombre as distrito_nombre
        FROM lugares_turisticos l
        LEFT JOIN distritos d ON l.id_distrito = d.id_distrito
        ORDER BY l.nombre ASC
    ");
    return $stmt->fetchAll();
}


}
