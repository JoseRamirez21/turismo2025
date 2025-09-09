<?php
// controllers/DepartamentoController.php
require_once __DIR__ . '/../models/Departamento.php';

class DepartamentoController {
    private $model;

    public function __construct() {
        $this->model = new Departamento();
    }

    // Listar todos
    public function index() {
        return $this->model->getAll();
    }

    // Ver detalle de un departamento
    public function show($id) {
        return $this->model->getById($id);
    }

    // Crear nuevo
    public function store($data) {
        $nombre = trim($data['nombre'] ?? '');
        if ($nombre === '') {
            return ['error' => 'El nombre no puede estar vacío'];
        }

        $this->model->create($nombre);
        return ['success' => 'Departamento creado correctamente'];
    }

    // Actualizar
    public function update($id, $data) {
        $nombre = trim($data['nombre'] ?? '');
        if ($nombre === '') {
            return ['error' => 'El nombre no puede estar vacío'];
        }

        $this->model->update($id, $nombre);
        return ['success' => 'Departamento actualizado correctamente'];
    }

    // Eliminar
    public function destroy($id) {
        $this->model->delete($id);
        return ['success' => 'Departamento eliminado correctamente'];
    }
}
