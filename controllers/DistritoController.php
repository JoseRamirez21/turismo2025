<?php
// controllers/DistritoController.php
require_once __DIR__ . '/../models/Distrito.php';
require_once __DIR__ . '/../models/Provincia.php';

class DistritoController {
    private $distritoModel;
    private $provinciaModel;

    public function __construct() {
        $this->distritoModel = new Distrito();
        $this->provinciaModel = new Provincia();
    }

    // Listar todos los distritos
    public function index(): array {
        return $this->distritoModel->getAll();
    }

    // Mostrar formulario de creación
    public function create(): array {
        return $this->provinciaModel->getAll(); // Para poblar select de provincias
    }

    // Guardar nuevo distrito (acepta arreglo)
    public function store(array $data): bool {
        return $this->distritoModel->create($data['id_provincia'], $data['nombre']);
    }

    // Obtener un distrito para edición
    public function edit(int $id): ?array {
        return $this->distritoModel->getById($id);
    }

    // Actualizar distrito
    public function update(int $id, array $data): bool {
        return $this->distritoModel->update($id, $data['id_provincia'], $data['nombre']);
    }

    // Eliminar distrito
    public function destroy(int $id): bool {
        return $this->distritoModel->delete($id);
    }
}
