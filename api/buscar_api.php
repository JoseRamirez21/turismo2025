<?php
require_once __DIR__ . '/../models/TokensApi.php';
require_once __DIR__ . '/../config/config.php';

$tokenModel = new TokensApi($pdo);

// Recibir datos desde JSON
$input = json_decode(file_get_contents('php://input'), true);
$token   = isset($input['token']) ? trim($input['token']) : '';
$termino = isset($input['dato']) ? trim($input['dato']) : '';

// Validar token
if (empty($token)) {
    echo json_encode(['status' => 'error', 'message' => '❌ Token no proporcionado.']);
    exit;
}

$resultado = $tokenModel->validarToken($token);
if (empty($resultado['success']) || $resultado['success'] !== true) {
    echo json_encode(['status' => 'error', 'message' => '❌ Token inválido o inactivo.']);
    exit;
}

if (empty($termino)) {
    echo json_encode(['status' => 'warning', 'message' => '⚠️ Ingrese un término de búsqueda.']);
    exit;
}

// Función para obtener datos desde listar.php
function obtenerLugares($termino) {
    $url = 'http://localhost/turismo_2025/views/admin/lugares/listar.php';
    $html = file_get_contents($url);
    if (!$html) return [];

    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($html);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);
    $lugares = [];

    foreach ($xpath->query("//table/tbody/tr") as $tr) {
        if (!($tr instanceof DOMElement)) continue;

        $tds = $tr->getElementsByTagName('td');
        if ($tds->length < 4) continue;

        $nombre   = trim($tds->item(1)->textContent ?? '');
        $tipo     = trim($tds->item(2)->textContent ?? '');
        $distrito = trim($tds->item(3)->textContent ?? '');

        // Filtrar por término
        if (stripos($nombre, $termino) !== false
            || stripos($tipo, $termino) !== false
            || stripos($distrito, $termino) !== false) {
            $lugares[] = [
                'nombre'   => $nombre,
                'tipo'     => $tipo,
                'distrito' => $distrito,
            ];
        }
    }

    return $lugares;
}

$resultados = obtenerLugares($termino);

echo json_encode(!empty($resultados) ? [
    'status' => 'success',
    'message' => '✅ Resultados encontrados.',
    'data' => $resultados
] : [
    'status' => 'info',
    'message' => '⚠️ No se encontraron resultados.'
]);
exit;
