<?php
// controllers/DistritoController.php
require_once __DIR__ . '/../models/Distrito.php';
require_once __DIR__ . '/../models/Provincia.php';
require_once __DIR__ . '/../config/cors.php';

class DistritoController {
    private $distritoModel;
    private $provinciaModel;

    public function __construct() {
        $this->distritoModel = new Distrito();
        $this->provinciaModel = new Provincia();
    }

    // Listar distritos con búsqueda, límite y paginación
    public function index(string $search = '', int $limit = 20, int $offset = 0): array {
        return $this->distritoModel->getAll($search, $limit, $offset);
    }

    // Contar distritos (para paginación)
    public function count(string $search = ''): int {
        return $this->distritoModel->count($search);
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
    $distrito = $this->distritoModel->getByIdFull($id);
    if (!$distrito) return null;

    // Obtener todas las provincias del departamento del distrito
    $provincias = $this->provinciaModel->getByDepartamento($distrito['id_departamento']);

    return [
        'distrito' => $distrito,
        'provincias' => $provincias
    ];
}


    // Actualizar distrito
    public function update(int $id, array $data): bool {
        return $this->distritoModel->update($id, $data['id_provincia'], $data['nombre']);
    }

    // Eliminar distrito
    public function destroy(int $id): bool {
        return $this->distritoModel->delete($id);
    }
    // Obtener un distrito por ID
public function show(int $id): ?array {
    return $this->distritoModel->getById($id);
}

}
