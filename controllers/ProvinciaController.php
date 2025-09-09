<?php
// controllers/ProvinciaController.php
require_once __DIR__ . '/../models/Provincia.php';
require_once __DIR__ . '/../models/Departamento.php';

class ProvinciaController {
    private $provinciaModel;
    private $departamentoModel;

    public function __construct() {
        $this->provinciaModel = new Provincia();
        $this->departamentoModel = new Departamento();
    }

    // Mostrar todas las provincias
    public function index(): array {
    return $this->provinciaModel->getAll();
}


    // Crear nueva provincia
    public function store(string $nombre, int $id_departamento): bool {
        if (empty($nombre) || $id_departamento <= 0) {
            return false;
        }
        return $this->provinciaModel->create($nombre, $id_departamento);
    }

    // Obtener datos de una provincia
    public function show(int $id): ?array {
        return $this->provinciaModel->getById($id);
    }

    // Editar provincia
    public function update(int $id, string $nombre, int $id_departamento): bool {
        if (empty($nombre) || $id <= 0) {
            return false;
        }
        return $this->provinciaModel->update($id, $nombre, $id_departamento);
    }

    // Eliminar provincia
    public function delete(int $id): bool {
        if ($id <= 0) {
            return false;
        }
        return $this->provinciaModel->delete($id);
    }

    // Para poblar selects de departamentos en formularios
    public function getDepartamentos(): array {
        return $this->departamentoModel->getAll();
    }
    
}
