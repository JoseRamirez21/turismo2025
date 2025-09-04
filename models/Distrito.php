<?php
// models/Distrito.php
require_once __DIR__ . '/../config/config.php';

class Distrito {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Obtener distritos por provincia_id
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
}
