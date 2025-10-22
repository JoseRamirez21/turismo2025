<?php
require_once __DIR__ . '/../models/TokensApi.php';
require_once __DIR__ . '/../config/config.php';

$tokenModel = new TokensApi($pdo);

// Recibir datos desde JSON
$input = json_decode(file_get_contents('php://input'), true);
$token   = isset($input['token']) ? trim($input['token']) : '';
$termino = isset($input['dato']) ? trim($input['dato']) : '';

// Verificación del token
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
        if ($tds->length < 2) continue;

        $tdContent = $tds->item(1)->nodeValue ?? '';
        $nombre = trim(preg_replace('/\s+/', ' ', $tdContent)); 
        $departamentos[] = $nombre;
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
// Función para obtener distritos de todas las páginas
function obtenerDistritos() {
    $urlsDist = [
        'http://localhost/turismo_2025/views/admin/distritos/listar.php',
        'http://localhost/turismo_2025/views/admin/distritos/listar.php?search=&limit=20&page=2',
        'http://localhost/turismo_2025/views/admin/distritos/listar.php?search=&limit=20&page=3',
        'http://localhost/turismo_2025/views/admin/distritos/listar.php?search=&limit=20&page=4',
        'http://localhost/turismo_2025/views/admin/distritos/listar.php?search=&limit=20&page=5',
        'http://localhost/turismo_2025/views/admin/distritos/listar.php?search=&limit=20&page=6',
        'http://localhost/turismo_2025/views/admin/distritos/listar.php?search=&limit=20&page=7',
        'http://localhost/turismo_2025/views/admin/distritos/listar.php?search=&limit=20&page=8'
    ];

    $distritos = [];
    foreach ($urlsDist as $urlDist) {
        $htmlDist = file_get_contents($urlDist);
        if (!$htmlDist) continue;

        $docDist = new DOMDocument();
        libxml_use_internal_errors(true);
        $docDist->loadHTML($htmlDist);
        libxml_clear_errors();

        $xpathDist = new DOMXPath($docDist);
        foreach ($xpathDist->query("//table/tbody/tr") as $tr) {
            $tds = $xpathDist->query("td", $tr);
            if ($tds->length < 4) continue;

            $distritos[] = [
                'distrito' => trim($tds->item(1)->textContent ?? ''),
                'provincia' => trim($tds->item(2)->textContent ?? ''),
                'departamento' => trim($tds->item(3)->textContent ?? '')
            ];
        }
    }

    return $distritos;
}


// Función para realizar la solicitud con cURL
function obtenerPaginaConCurl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Seguir redirecciones si es necesario
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Establecer un User-Agent para evitar bloqueos

    $html = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error en la solicitud cURL: ' . curl_error($ch);
    }
    curl_close($ch);
    return $html;
}

// Función para obtener lugares turísticos de todas las páginas
function obtenerLugares($termino, $urls) {
    $lugares = [];
    $distritos = obtenerDistritos(); // Obtener distritos, provincias y departamentos
    $provincias = obtenerProvincias();
    $departamentos = obtenerDepartamentos();

    foreach ($urls as $url) {
        $htmlLug = obtenerPaginaConCurl($url); // Usar cURL para obtener la página
        if (!$htmlLug) continue;

        $docLug = new DOMDocument();
        libxml_use_internal_errors(true);
        $docLug->loadHTML($htmlLug);
        libxml_clear_errors();

        $xpathLug = new DOMXPath($docLug);
        foreach ($xpathLug->query("//table/tbody/tr") as $tr) {
            $tds = $xpathLug->query("td", $tr);
            if ($tds->length < 4) continue;

            $nombre   = trim($tds->item(1)->textContent ?? '');
            $tipo     = trim($tds->item(2)->textContent ?? '');
            $distrito = trim($tds->item(3)->textContent ?? '');

            // Buscar la provincia y departamento correspondiente al distrito
            $provincia = $departamento = '—';
            foreach ($distritos as $dist) {
                if (mb_stripos(mb_strtolower($dist['distrito']), mb_strtolower($distrito)) !== false) {
                    $provincia = $dist['provincia'];
                    $departamento = $dist['departamento'];
                    break;
                }
            }

            $terminoNormalizado = mb_strtolower(trim($termino));
            if (
                mb_stripos(mb_strtolower($nombre), $terminoNormalizado) !== false ||
                mb_stripos(mb_strtolower($tipo), $terminoNormalizado) !== false ||
                mb_stripos(mb_strtolower($distrito), $terminoNormalizado) !== false ||
                mb_stripos(mb_strtolower($provincia), $terminoNormalizado) !== false ||
                mb_stripos(mb_strtolower($departamento), $terminoNormalizado) !== false
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
    }

    return $lugares;
}

// URLs de las 8 páginas de lugares turísticos
$urls = [
    'http://localhost/turismo_2025/views/admin/lugares/listar.php',
    'http://localhost/turismo_2025/views/admin/lugares/listar.php?page=2&limit=20&search=',
    'http://localhost/turismo_2025/views/admin/lugares/listar.php?page=3&limit=20&search=',
    'http://localhost/turismo_2025/views/admin/lugares/listar.php?page=4&limit=20&search=',
    'http://localhost/turismo_2025/views/admin/lugares/listar.php?page=5&limit=20&search=',
    'http://localhost/turismo_2025/views/admin/lugares/listar.php?page=6&limit=20&search=',
    'http://localhost/turismo_2025/views/admin/lugares/listar.php?page=7&limit=20&search=',
    'http://localhost/turismo_2025/views/admin/lugares/listar.php?page=8&limit=20&search='
];

// Obtener lugares
$lugares = obtenerLugares($termino, $urls);

// Responder con los datos encontrados
echo json_encode(!empty($lugares) ? [
    'status' => 'success',
    'message' => '✅ Resultados encontrados.',
    'data' => $lugares
] : [
    'status' => 'info',
    'message' => '⚠️ No se encontraron resultados.',
    'data' => []
]);

exit;
