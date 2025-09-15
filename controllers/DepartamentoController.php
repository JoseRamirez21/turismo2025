<?php
// controllers/DepartamentoController.php
require_once __DIR__ . '/../models/Departamento.php';

class DepartamentoController {
    private $model;

    public function __construct() {
        $this->model = new Departamento();
    }

    // Listar departamentos con búsqueda y paginación
    public function index(string $search = '', int $page = 1, int $limit = 20): array {
        $page = max(1, $page); // página mínima = 1
        $offset = ($page - 1) * $limit;

        $data = $this->model->getAll($search, $limit, $offset); // datos
        $total = $this->model->count($search); // total de registros
        $totalPages = (int) ceil($total / $limit); // total de páginas

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'limit' => $limit,
        ];
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
    // Dentro de DepartamentoController
public function count(string $search = ''): int {
    return $this->model->count($search);
}

}
