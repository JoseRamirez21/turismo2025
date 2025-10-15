<?php
require_once __DIR__ . '/../models/TokensApi.php';
require_once __DIR__ . '/../config/cors.php';

class TokensApiController {
    private $model;

    public function __construct($pdo) {
        $this->model = new TokensApi($pdo);
    }

    public function index() {
        return $this->model->getAll();
    }

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update($id, array $data) {
        return $this->model->update($id, $data);
    }

    public function destroy($id) {
        return $this->model->delete($id);
    }

    public function getTokenById($id) {
        return $this->model->getById($id);
    }

    public function regenerateToken($id) {
        return $this->model->regenerateToken($id);
    }

    // 🔹 Nuevo método que llama al modelo
    public function validarToken($token) {
        return $this->model->validarToken($token);
    }
}
