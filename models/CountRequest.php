<?php
class CountRequest {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 📌 Obtener todos los registros con info de token y cliente
    public function getAll() {
        try {
            $sql = "
                SELECT cr.*, t.token, t.id_client_api, c.nombre, c.apellido
                FROM count_request cr
                LEFT JOIN tokens_api t ON cr.id_token = t.id
                LEFT JOIN client_api c ON t.id_client_api = c.id
                ORDER BY cr.id DESC
            ";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("❌ Error al obtener count_request: " . $e->getMessage());
            return [];
        }
    }

    // 📌 Obtener registro por ID
    public function getById($id) {
        try {
            $sql = "
                SELECT cr.*, t.token, t.id_client_api, c.nombre, c.apellido
                FROM count_request cr
                LEFT JOIN tokens_api t ON cr.id_token = t.id
                LEFT JOIN client_api c ON t.id_client_api = c.id
                WHERE cr.id = :id
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("❌ Error al obtener count_request por ID: " . $e->getMessage());
            return false;
        }
    }

    // 📌 Crear nuevo registro
    public function create($data) {
        try {
            $sql = "
                INSERT INTO count_request (id_token, tipo, fecha)
                VALUES (:id_token, :tipo, NOW())
            ";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':id_token' => $data['id_token'],
                ':tipo'     => $data['tipo']
            ]);
        } catch (PDOException $e) {
            error_log("❌ Error al crear count_request: " . $e->getMessage());
            return false;
        }
    }

    // 📌 Actualizar registro
    public function update($id, $data) {
        try {
            $sql = "
                UPDATE count_request
                SET id_token = :id_token, tipo = :tipo
                WHERE id = :id
            ";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':id_token' => $data['id_token'],
                ':tipo'     => $data['tipo'],
                ':id'       => $id
            ]);
        } catch (PDOException $e) {
            error_log("❌ Error al actualizar count_request: " . $e->getMessage());
            return false;
        }
    }

    // 📌 Eliminar registro
    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM count_request WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("❌ Error al eliminar count_request: " . $e->getMessage());
            return false;
        }
    }
}
