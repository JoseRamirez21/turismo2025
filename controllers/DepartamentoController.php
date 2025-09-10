<?php
// controllers/DepartamentoController.php
require_once __DIR__ . '/../models/Departamento.php';

class DepartamentoController {
    private $model;

    public function __construct() {
        $this->model = new Departamento();
    }

    // Listar departamentos con búsqueda y límite
    public function index(string $search = '', int $limit = 20, int $offset = 0): array {
        return $this->model->getAll($search, $limit, $offset);
    }

    // Contar departamentos (para paginación)
    public function count(string $search = ''): int {
        return $this->model->count($search);
    }

    // Obtener un departamento
    public function show(int $id): ?array {
        return $this->model->getById($id);
    }

    // Crear nuevo departamento
    public function store(string $nombre): bool {
        if (trim($nombre) === '') return false;
        return $this->model->create($nombre);
    }

    // Actualizar departamento
    public function update(int $id, string $nombre): bool {
        if ($id <= 0 || trim($nombre) === '') return false;
        return $this->model->update($id, $nombre);
    }

    // Eliminar departamento
    public function delete(int $id): bool {
        if ($id <= 0) return false;
        return $this->model->delete($id);
    }
}
