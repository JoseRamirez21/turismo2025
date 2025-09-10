<?php
// controllers/LugarController.php
require_once __DIR__ . '/../models/Lugar.php';
require_once __DIR__ . '/../models/Distrito.php';

class LugarController {
    private $lugarModel;
    private $distritoModel;

    public function __construct() {
        $this->lugarModel = new Lugar();
        $this->distritoModel = new Distrito();
    }

    // 🔹 Listar lugares con límite, offset y búsqueda
    public function index(int $limit = 20, int $offset = 0, string $search = ''): array {
        return $this->lugarModel->getAll($limit, $offset, $search);
    }

    // 🔹 Contar lugares (para paginación)
    public function count(string $search = ''): int {
        return $this->lugarModel->count($search);
    }

    // 🔹 Obtener distritos para select en creación/edición
    public function getDistritos(): array {
        return $this->distritoModel->getAll();
    }

    // 🔹 Guardar un nuevo lugar
    public function store(array $data): bool {
        return $this->lugarModel->create($data);
    }

    // 🔹 Obtener un lugar para edición
    public function show(int $id): ?array {
        return $this->lugarModel->getById($id);
    }

    // 🔹 Actualizar un lugar existente
    public function update(int $id, array $data): bool {
        return $this->lugarModel->update($id, $data);
    }

    // 🔹 Eliminar un lugar
    public function delete(int $id): bool {
        return $this->lugarModel->delete($id);
    }
}

