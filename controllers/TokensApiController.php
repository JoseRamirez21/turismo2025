<?php
require_once __DIR__ . '/../models/TokensApi.php';
require_once __DIR__ . '/../config/cors.php';

class TokensApiController {
    private $model;

    public function __construct($pdo) {
        $this->model = new TokensApi($pdo);
    }

    // ✅ Listar todos
    public function index() {
        return $this->model->getAll();
    }

    // ✅ Crear
    public function create(array $data) {
        return $this->model->create($data);
    }

    // ✅ Actualizar
    public function update($id, array $data) {
        return $this->model->update($id, $data);
    }

    // ✅ Eliminar
    public function destroy($id) {
        return $this->model->delete($id);
    }

    // ✅ Obtener por ID (este es el que se usa en edit.php)
    public function getTokenById($id) {
        return $this->model->getById($id);
    }

    // ✅ Regenerar token
    public function regenerateToken($id) {
        return $this->model->regenerateToken($id);
    }
}
