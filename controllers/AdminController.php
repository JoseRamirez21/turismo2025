<?php
// controllers/AdminController.php
require_once __DIR__ . '/../models/Admin.php';

class AdminController {
    private $model;

    public function __construct() {
        $this->model = new Admin();
    }

    // 🔹 Listar administradores con búsqueda y paginación
    public function index(string $search = '', int $limit = 20, int $offset = 0): array {
        return $this->model->getAll($search, $limit, $offset);
    }

    // 🔹 Contar administradores (para paginación)
    public function count(string $search = ''): int {
        return $this->model->count($search);
    }

    // 🔹 Obtener un administrador por ID
    public function show(int $id): ?array {
        return $this->model->getById($id);
    }

    // 🔹 Crear nuevo administrador (solo nombre, email, password)
    public function store(string $nombre, string $email, string $password): bool {
        if (trim($nombre) === '' || trim($email) === '' || trim($password) === '') {
            return false;
        }
        return $this->model->create($nombre, $email, $password);
    }

    // 🔹 Actualizar administrador (sin usuario)
    public function update(int $id, string $nombre, string $email, ?string $password = null): bool {
        if ($id <= 0 || trim($nombre) === '' || trim($email) === '') {
            return false;
        }
        return $this->model->update($id, $nombre, $email, $password);
    }

    // 🔹 Eliminar administrador
    public function delete(int $id): bool {
        if ($id <= 0) return false;
        return $this->model->delete($id);
    }

    // 🔹 Login con email y password
    public function login(string $email, string $clave): ?array {
        if (trim($email) === '' || trim($clave) === '') return null;
        return $this->model->login($email, $clave);
    }
}
