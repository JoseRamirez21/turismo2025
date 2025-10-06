<?php
// controllers/AjaxController.php
require_once __DIR__ . '/../models/Provincia.php';
require_once __DIR__ . '/../config/cors.php';

header('Content-Type: application/json');

$provinciaModel = new Provincia();

$action = $_GET['action'] ?? '';
$id_departamento = $_GET['id_departamento'] ?? null;

if ($action === 'provincias' && $id_departamento) {
    $provincias = $provinciaModel->getByDepartamento((int)$id_departamento);
    echo json_encode($provincias);
    exit;
}

// Si no hay acción válida
echo json_encode([]);
exit;
