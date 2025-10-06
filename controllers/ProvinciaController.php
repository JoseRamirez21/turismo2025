<?php
// controllers/ProvinciaController.php
require_once __DIR__ . '/../models/Provincia.php';
require_once __DIR__ . '/../models/Departamento.php';
require_once __DIR__ . '/../config/cors.php';

class ProvinciaController {
    private $provinciaModel;
    private $departamentoModel;

    public function __construct() {
        $this->provinciaModel = new Provincia();
        $this->departamentoModel = new Departamento();
    }

    /**
     * Listar provincias con búsqueda, límite y offset para paginación
     *
     * @param string $search Texto a buscar por nombre
     * @param int $limit Cantidad máxima de registros por página
     * @param int $offset Registro desde donde empezar
     * @return array
     */
    public function index(string $search = '', int $limit = 20, int $offset = 0): array {
        return $this->provinciaModel->getAll($search, $limit, $offset);
    }

    // Contar provincias (para calcular páginas)
    public function count(string $search = ''): int {
        return $this->provinciaModel->count($search);
    }

    // Obtener todos los departamentos para poblar select
    public function getDepartamentos(): array {
        return $this->departamentoModel->getAll();
    }

    // Crear nueva provincia
    public function store(array $data): bool {
        $nombre = $data['nombre'] ?? '';
        $id_departamento = $data['id_departamento'] ?? 0;

        if (empty($nombre) || $id_departamento <= 0) return false;

        return $this->provinciaModel->create($nombre, $id_departamento);
    }

    // Obtener una provincia por ID
    public function show(int $id): ?array {
        return $this->provinciaModel->getById($id);
    }

    // Actualizar provincia
    public function update(int $id, array $data): bool {
        $nombre = $data['nombre'] ?? '';
        $id_departamento = $data['id_departamento'] ?? 0;

        if (empty($nombre) || $id <= 0) return false;

        return $this->provinciaModel->update($id, $nombre, $id_departamento);
    }

    // Eliminar provincia
    public function delete(int $id): bool {
        if ($id <= 0) return false;
        return $this->provinciaModel->delete($id);
    }
}
