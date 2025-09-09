<?php
// controllers/LugarController.php
require_once __DIR__ . '/../models/Lugar.php';

class LugarController {
    private $model;

    public function __construct() {
        $this->model = new Lugar();
    }

    // 🔹 Listar todos los lugares
    public function index(): array {
        return $this->model->getAll();
    }

    // 🔹 Obtener lugares por distrito
    public function getByDistrito(int $id_distrito): array {
        return $this->model->getByDistrito($id_distrito);
    }

    // 🔹 Guardar un nuevo lugar
    public function store(array $data): bool {
        return $this->model->create($data);
    }

    // 🔹 Obtener un lugar para edición
    public function edit(int $id): ?array {
        return $this->model->getById($id);
    }

    // 🔹 Actualizar un lugar existente
    public function update(int $id, array $data): bool {
        return $this->model->update($id, $data);
    }

    // 🔹 Eliminar un lugar
    public function destroy(int $id): bool {
        return $this->model->delete($id);
    }
}
