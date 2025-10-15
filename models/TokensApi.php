<?php

class TokensApi {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 📌 Crear nuevo token (se genera automáticamente con ID del cliente al final)
    public function create($data)
    {
        try {
            $randomToken = bin2hex(random_bytes(16)); // 32 caracteres hexadecimales
            $token = $randomToken . '-' . $data['id_client_api'];

            $sql = "INSERT INTO tokens_api (id_client_api, token, fecha_registro, estado) 
                    VALUES (:id_client_api, :token, NOW(), :estado)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id_client_api', $data['id_client_api']);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':estado', $data['estado']);
            $stmt->execute();

            return [
                'success' => true,
                'message' => 'Token creado correctamente',
                'token' => $token
            ];
        } catch (PDOException $e) {
            error_log("❌ Error al crear token: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al crear token'
            ];
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

    // 📌 Actualizar estado del token
    public function update($id, $data)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE tokens_api 
                SET estado = :estado
                WHERE id = :id
            ");
            $stmt->execute([
                ':estado' => $data['estado'],
                ':id'     => $id
            ]);

            return [
                'success' => true,
                'message' => 'Token actualizado correctamente'
            ];
        } catch (PDOException $e) {
            error_log("❌ Error al actualizar token: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al actualizar token'
            ];
        }
    }

    // 📌 Regenerar token (mantiene el mismo cliente)
    public function regenerateToken($id)
    {
        try {
            $current = $this->getById($id);
            if (!$current) {
                return [
                    'success' => false,
                    'message' => 'Token no encontrado'
                ];
            }

            $newToken = bin2hex(random_bytes(16)) . '-' . $current['id_client_api'];

            $stmt = $this->pdo->prepare("
                UPDATE tokens_api 
                SET token = :token 
                WHERE id = :id
            ");
            $stmt->execute([
                ':token' => $newToken,
                ':id'    => $id
            ]);

            return [
                'success' => true,
                'message' => 'Token regenerado correctamente',
                'token' => $newToken
            ];
        } catch (PDOException $e) {
            error_log("❌ Error al regenerar token: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al regenerar token'
            ];
        }
    }

    // 📌 Eliminar token
    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM tokens_api WHERE id = :id");
            $stmt->execute([':id' => $id]);

            return [
                'success' => true,
                'message' => 'Token eliminado correctamente'
            ];
        } catch (PDOException $e) {
            error_log("❌ Error al eliminar token: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al eliminar token'
            ];
        }
    }

    // 📌 Validar token (solo tokens activos)
    public function validarToken($token)
    {
        $query = "SELECT * FROM tokens_api WHERE token = :token AND estado = 'activo' LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tokenData) {
            return [
                'status' => 'success',
                'message' => 'Token válido',
                'data' => $tokenData
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Token inválido o inactivo'
            ];
        }
    }
}
