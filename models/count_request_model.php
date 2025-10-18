<?php
require_once __DIR__ . '/../config/config.php';

class CountRequestModel
{
    private $db;

    public function __construct()
    {
        // Usamos tu clase Database con PDO
        $this->db = (new Database())->getConnection();
    }

    // Obtener todos los registros
    public function obtenerCountRequests()
    {
        $query = "SELECT * FROM count_request";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un registro por su ID
    public function obtenerCountRequestPorId($id)
    {
        $query = "SELECT * FROM count_request WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Agregar nuevo registro
    public function agregarCountRequest($id_token, $tipo, $fecha)
    {
        $query = "INSERT INTO count_request (id_token, tipo, fecha) VALUES (:id_token, :tipo, :fecha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_token", $id_token, PDO::PARAM_INT);
        $stmt->bindValue(":tipo", $tipo, PDO::PARAM_STR);
        $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Actualizar registro
    public function actualizarCountRequest($id, $id_token, $tipo, $fecha)
    {
        $query = "UPDATE count_request 
                  SET id_token = :id_token, tipo = :tipo, fecha = :fecha 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":id_token", $id_token, PDO::PARAM_INT);
        $stmt->bindValue(":tipo", $tipo, PDO::PARAM_STR);
        $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Eliminar registro
    public function eliminarCountRequest($id)
    {
        $query = "DELETE FROM count_request WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
