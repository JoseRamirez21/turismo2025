<?php
require_once __DIR__ . '/../models/TokensApi.php';
require_once __DIR__ . '/../config/cors.php';

class TokensApiController {
    private $model;

    public function __construct($pdo) {
        $this->model = new TokensApi($pdo);
    }

    // 🔹 Listar todos los tokens
    public function index() {
        return $this->model->getAll();
    }

    // 🔹 Crear un nuevo token
    public function create(array $data) {
        return $this->model->create($data);
    }

    // 🔹 Actualizar token
    public function update($id, array $data) {
        return $this->model->update($id, $data);
    }

    // 🔹 Eliminar token
    public function destroy($id) {
        return $this->model->delete($id);
    }

    // 🔹 Obtener token por ID
    public function getTokenById($id) {
        return $this->model->getById($id);
    }

    // 🔹 Regenerar token
    public function regenerateToken($id) {
        return $this->model->regenerateToken($id);
    }

    // 🔹 Validar token
    public function validarToken($token) {
        // 🔸 Llama directamente al modelo
        $resultado = $this->model->validarToken($token);

        // 🔸 Retorna siempre en formato estándar
        if ($resultado['success']) {
            // Aquí puedes guardar sesión si es necesario
            session_start();
            $_SESSION['token_valido'] = $resultado['data']['token'];
            $_SESSION['id_client_api'] = $resultado['data']['id_client_api'];
        }

        return $resultado;
    }
}
