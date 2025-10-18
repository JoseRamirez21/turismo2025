<?php
require_once __DIR__ . '/../models/TokenModel.php';

$input = json_decode(file_get_contents('php://input'), true);
$token   = isset($input['token']) ? trim($input['token']) : '';
$termino = isset($input['dato']) ? trim($input['dato']) : '';

$tokenModel = new TokenModel();

// Validar token
if (!$token || !$tokenModel->validarToken($token)) {
    echo json_encode(['status' => 'error', 'message' => '❌ Token inválido o inactivo.']);
    exit;
}

if (empty($termino)) {
    echo json_encode(['status' => 'warning', 'message' => '⚠️ Ingrese un término de búsqueda.']);
    exit;
}

// Función para jalar datos desde la página
function obtenerLugaresDesdePagina($termino) {
    $url = 'http://localhost/turismo_2025/views/admin/lugares/listar.php'; // página que contiene los lugares
    $html = file_get_contents($url);

    if (!$html) return [];

    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($html);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);
    $lugares = [];

    // Aquí dependemos de la estructura HTML de index.php
    // Por ejemplo, si cada lugar está en un div con clase 'lugar-turistico'
    foreach ($xpath->query("//div[contains(@class,'lugar-turistico')]") as $div) {
        $nombre = $xpath->query(".//h5", $div)->item(0)?->textContent ?? '';
        $tipo = $xpath->query(".//p[@class='tipo']", $div)->item(0)?->textContent ?? '';
        $descripcion = $xpath->query(".//p[@class='descripcion']", $div)->item(0)?->textContent ?? '';
        $ubicacion = $xpath->query(".//p[@class='ubicacion']", $div)->item(0)?->textContent ?? '';

        // Filtrar por término (ignora mayúsculas/minúsculas)
        if (stripos($nombre, $termino) !== false
            || stripos($tipo, $termino) !== false
            || stripos($descripcion, $termino) !== false
            || stripos($ubicacion, $termino) !== false) {
            $lugares[] = [
                'lugar' => trim($nombre),
                'tipo' => trim($tipo),
                'descripcion' => trim($descripcion),
                'ubicacion' => trim($ubicacion),
            ];
        }
    }

    return $lugares;
}

$resultados = obtenerLugaresDesdePagina($termino);

echo json_encode(!empty($resultados) ? [
    'status' => 'success',
    'message' => '✅ Resultados encontrados.',
    'data' => $resultados
] : [
    'status' => 'info',
    'message' => '⚠️ No se encontraron resultados.'
]);
exit;
