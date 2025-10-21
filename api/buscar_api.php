<?php
require_once __DIR__ . '/../models/TokensApi.php';
require_once __DIR__ . '/../config/config.php';

$tokenModel = new TokensApi($pdo);

// Recibir datos desde JSON
$input = json_decode(file_get_contents('php://input'), true);
$token   = isset($input['token']) ? trim($input['token']) : '';
$termino = isset($input['dato']) ? trim($input['dato']) : '';

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

// Función para obtener departamentos
function obtenerDepartamentos() {
    $urlDep = 'http://localhost/turismo_2025/views/admin/departamentos/listar.php';
    $htmlDep = file_get_contents($urlDep);
    if (!$htmlDep) return [];

    $docDep = new DOMDocument();
    libxml_use_internal_errors(true);
    $docDep->loadHTML($htmlDep);
    libxml_clear_errors();

    $xpathDep = new DOMXPath($docDep);
    $departamentos = [];
    foreach ($xpathDep->query("//table/tbody/tr") as $tr) {
        $tds = $xpathDep->query("td", $tr);
        if ($tds->length < 2) continue; // corregido

        // Extraer solo el texto visible del td
        $nombreNode = $xpathDep->query("text()", $tds->item(1));
        $departamentos[] = trim($nombreNode->item(0)->nodeValue ?? '');
    }
    return $departamentos;
}

// Función para obtener provincias
function obtenerProvincias() {
    $urlProv = 'http://localhost/turismo_2025/views/admin/provincias/listar.php';
    $htmlProv = file_get_contents($urlProv);
    if (!$htmlProv) return [];

    $docProv = new DOMDocument();
    libxml_use_internal_errors(true);
    $docProv->loadHTML($htmlProv);
    libxml_clear_errors();

    $xpathProv = new DOMXPath($docProv);
    $provincias = [];
    foreach ($xpathProv->query("//table/tbody/tr") as $tr) {
        $tds = $xpathProv->query("td", $tr);
        if ($tds->length < 3) continue;
        $provincias[] = [
            'provincia' => trim($tds->item(1)->textContent ?? ''),
            'departamento' => trim($tds->item(2)->textContent ?? '')
        ];
    }
    return $provincias;
}

// Función para obtener distritos
function obtenerDistritos() {
    $urlDist = 'http://localhost/turismo_2025/views/admin/distritos/listar.php';
    $htmlDist = file_get_contents($urlDist);
    if (!$htmlDist) return [];

    $docDist = new DOMDocument();
    libxml_use_internal_errors(true);
    $docDist->loadHTML($htmlDist);
    libxml_clear_errors();

    $xpathDist = new DOMXPath($docDist);
    $distritos = [];
    foreach ($xpathDist->query("//table/tbody/tr") as $tr) {
        $tds = $xpathDist->query("td", $tr);
        if ($tds->length < 4) continue;
        $distritos[] = [
            'distrito' => trim($tds->item(1)->textContent ?? ''),
            'provincia' => trim($tds->item(2)->textContent ?? ''),
            'departamento' => trim($tds->item(3)->textContent ?? '')
        ];
    }
    return $distritos;
}

// Función para obtener lugares turísticos filtrados
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

    $distritos = obtenerDistritos();

    foreach ($xpathLug->query("//table/tbody/tr") as $tr) {
        $tds = $xpathLug->query("td", $tr);
        if ($tds->length < 4) continue;

        $nombre   = trim($tds->item(1)->textContent ?? '');
        $tipo     = trim($tds->item(2)->textContent ?? '');
        $distrito = trim($tds->item(3)->textContent ?? '');

        // Buscar ubicación del distrito
        $provincia = $departamento = '—';
        foreach ($distritos as $dist) {
            if (mb_strtolower($dist['distrito']) === mb_strtolower($distrito)) {
                $provincia = $dist['provincia'];
                $departamento = $dist['departamento'];
                break;
            }
        }

        // Filtrar por jerarquía incluyendo departamento
        if (
            mb_stripos($nombre, $termino) !== false ||
            mb_stripos($tipo, $termino) !== false ||
            mb_stripos($distrito, $termino) !== false ||
            mb_stripos($provincia, $termino) !== false ||
            mb_stripos($departamento, $termino) !== false
        ) {
            $lugares[] = [
                'nombre' => $nombre,
                'tipo' => $tipo,
                'distrito' => $distrito,
                'provincia' => $provincia,
                'departamento' => $departamento,
                'imagen' => 'https://i.pinimg.com/1200x/7f/c3/68/7fc368451428d898438268d36383d154.jpg'
            ];
        }
    }

    return $lugares;
}

$lugares = obtenerLugares($termino);

echo json_encode(!empty($lugares) ? [
    'status' => 'success',
    'message' => '✅ Resultados encontrados.',
    'data' => $lugares
] : [
    'status' => 'info',
    'message' => '⚠️ No se encontraron resultados.'
]);
exit;
