<?php
require_once __DIR__ . '/../models/CountRequest.php';

class CountRequestController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new CountRequest($pdo);
    }

    // ✅ Listar todos los Count Requests
    public function index()
    {
        return $this->model->getAll();
    }

    // ✅ Crear un nuevo Count Request
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // ✅ Actualizar un Count Request
    public function update($id, array $data)
    {
        return $this->model->update($id, $data);
    }

    // ✅ Eliminar un Count Request
    public function destroy($id)
    {
        return $this->model->delete($id);
    }

    // ✅ Obtener un Count Request por ID (para Editar/Ver)
    public function getRequestById($id)
    {
        return $this->model->getById($id);
    }
}
