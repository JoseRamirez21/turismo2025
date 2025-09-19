<?php
require_once __DIR__ . '/../models/ClientApi.php';

class ClientApiController {
    private $model;

    public function __construct($db) {
        $this->model = new ClientApi($db);
    }

    public function index() {
        return $this->model->getAll();
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function edit($id, $data) {
        return $this->model->update($id, $data);
    }

    public function delete($id) {
        return $this->model->delete($id);
    }

    public function find($id) {
        return $this->model->getById($id);
    }
}
