<?php
require_once __DIR__ . '/../models/TokensApi.php';

class TokensApiController {
    private $model;

    public function __construct($pdo) {
        $this->model = new TokensApi($pdo);
    }

    // Obtener todos los tokens
    public function index() {
        return $this->model->getAll();
    }

    // Crear un token
    public function create(array $data) {
        return $this->model->create($data);
    }

    // Actualizar un token
    public function update($id, array $data) {
        return $this->model->update($id, $data);
    }

    // Eliminar un token
    public function destroy($id) {
        return $this->model->delete($id);
    }

    // ✅ Obtener un token por ID
    public function getTokenById($id) {
        return $this->model->getById($id);
    }
}
