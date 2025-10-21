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

// Función para obtener lugares turísticos
function obtenerLugares($termino) {
    $urlLugares = 'http://localhost/turismo_2025/views/admin/lugares/listar.php';
    $htmlLug = file_get_contents($urlLugares);
    if (!$htmlLug) return [];

    $docLug = new DOMDocument();
    libxml_use_internal_errors(true);
    $docLug->loadHTML($htmlLug);
    libxml_clear_errors();

    $xpathLug = new DOMXPath($docLug);
    $lugares = [];

    foreach ($xpathLug->query("//table/tbody/tr") as $tr) {
        if (!($tr instanceof DOMElement)) continue;

        $tds = $xpathLug->query("td", $tr);
        if ($tds->length < 4) continue;

        $nombre   = trim($tds->item(1)->textContent ?? '');
        $tipo     = trim($tds->item(2)->textContent ?? '');
        $distrito = trim($tds->item(3)->textContent ?? '');

        // Filtrar por término
        if (stripos($nombre, $termino) !== false
            || stripos($tipo, $termino) !== false
            || stripos($distrito, $termino) !== false) {

            $lugares[] = [
                'nombre' => $nombre,
                'tipo' => $tipo,
                'distrito' => $distrito,
            ];
        }
    }

    return $lugares;
}

// Función para obtener provincia y departamento desde distritos
function obtenerUbicacion($distrito) {
    $urlDist = 'http://localhost/turismo_2025/views/admin/distritos/listar.php';
    $htmlDist = file_get_contents($urlDist);
    if (!$htmlDist) return ['provincia'=>'—', 'departamento'=>'—'];

    $docDist = new DOMDocument();
    libxml_use_internal_errors(true);
    $docDist->loadHTML($htmlDist);
    libxml_clear_errors();

    $xpathDist = new DOMXPath($docDist);

    foreach ($xpathDist->query("//table/tbody/tr") as $tr) {
        if (!($tr instanceof DOMElement)) continue;

        $tds = $xpathDist->query("td", $tr);
        if ($tds->length < 4) continue;

        $dist = trim($tds->item(1)->textContent ?? '');
        $prov = trim($tds->item(2)->textContent ?? '');
        $dep  = trim($tds->item(3)->textContent ?? '');

        if (strcasecmp($dist, $distrito) === 0) {
            return ['provincia'=>$prov, 'departamento'=>$dep];
        }
    }

    return ['provincia'=>'—', 'departamento'=>'—'];
}

$lugares = obtenerLugares($termino);

// Agregar provincia, departamento e imagen de prueba
foreach ($lugares as &$lugar) {
    $ubic = obtenerUbicacion($lugar['distrito']);
    $lugar['provincia'] = $ubic['provincia'];
    $lugar['departamento'] = $ubic['departamento'];
    $lugar['imagen'] = 'https://i.pinimg.com/1200x/7f/c3/68/7fc368451428d898438268d36383d154.jpg'; // prueba
}

echo json_encode(!empty($lugares) ? [
    'status' => 'success',
    'message' => '✅ Resultados encontrados.',
    'data' => $lugares
] : [
    'status' => 'info',
    'message' => '⚠️ No se encontraron resultados.'
]);
exit;
