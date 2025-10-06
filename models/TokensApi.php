<?php
class TokensApi {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 📌 Crear nuevo token (generado automáticamente con ID del cliente al final)
    public function create($data)
    {
        try {
            $randomToken = bin2hex(random_bytes(16)); // 32 caracteres hex
            $token = $randomToken . '-' . $data['id_client_api'];

            $sql = "INSERT INTO tokens_api (id_client_api, token, fecha_registro, estado) 
                    VALUES (:id_client_api, :token, NOW(), :estado)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id_client_api', $data['id_client_api']);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':estado', $data['estado']);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("❌ Error al crear token: " . $e->getMessage());
            return false;
        }
    }

    // 📌 Obtener todos los tokens
    public function getAll() {
        $sql = "
            SELECT t.*, c.nombre, c.apellido 
            FROM tokens_api t
            LEFT JOIN client_api c ON c.id = t.id_client_api
            ORDER BY t.id DESC
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 📌 Obtener un token por ID (con datos del cliente)
    public function getById($id) {
        $sql = "
            SELECT t.*, c.nombre, c.apellido 
            FROM tokens_api t
            LEFT JOIN client_api c ON c.id = t.id_client_api
            WHERE t.id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 📌 Actualizar solo estado (ya no token ni cliente desde la edición)
    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE tokens_api 
            SET estado = :estado
            WHERE id = :id
        ");
        return $stmt->execute([
            ':estado' => $data['estado'],
            ':id'     => $id
        ]);
    }

    // 📌 Regenerar token automáticamente (mantiene mismo cliente)
    public function regenerateToken($id)
    {
        try {
            $current = $this->getById($id);
            if (!$current) return false;

            $newToken = bin2hex(random_bytes(16)) . '-' . $current['id_client_api'];

            $stmt = $this->pdo->prepare("
                UPDATE tokens_api 
                SET token = :token 
                WHERE id = :id
            ");
            return $stmt->execute([
                ':token' => $newToken,
                ':id'    => $id
            ]);
        } catch (PDOException $e) {
            error_log("❌ Error al regenerar token: " . $e->getMessage());
            return false;
        }
    }

    // 📌 Eliminar token
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tokens_api WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
