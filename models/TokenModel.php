<?php
require_once __DIR__ . '/../config/config.php';

class TokenModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /**
     * 🔍 Validar token: existe y está activo
     * @param string $token
     * @return bool
     */
    public function validarToken(string $token): bool {
        try {
            $sql = "SELECT * FROM tokens_api WHERE token = :token AND estado = 1 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount() > 0; // true si está activo
        } catch (PDOException $e) {
            error_log("Error en TokenModel->validarToken: " . $e->getMessage());
            return false; // si hay error, consideramos token inválido
        }
    }

    /**
     * Obtener todos los tokens activos
     * @return array
     */
    public function obtenerTokensActivos(): array {
        try {
            $sql = "SELECT token, id_client_api, fecha_registro FROM tokens_api WHERE estado = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("Error en TokenModel->obtenerTokensActivos: " . $e->getMessage());
            return [];
        }
    }
}
