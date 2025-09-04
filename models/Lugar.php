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

}
