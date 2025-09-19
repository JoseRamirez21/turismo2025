<?php
require_once __DIR__ . '/../config/config.php';

class ClientApi {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM client_api WHERE estado = 1 ORDER BY id DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM client_api WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO client_api (dni, nombre, apellido, telefono, correo, estado)
                VALUES (?, ?, ?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['dni'],
            $data['nombre'],
            $data['apellido'],
            $data['telefono'],
            $data['correo']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE client_api 
                SET dni=?, nombre=?, apellido=?, telefono=?, correo=?, estado=?
                WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['dni'],
            $data['nombre'],
            $data['apellido'],
            $data['telefono'],
            $data['correo'],
            $data['estado'],
            $id
        ]);
    }

    public function delete($id) {
        // Borrado lógico
        $sql = "UPDATE client_api SET estado = 0 WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
