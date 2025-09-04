<?php
// views/lugares/detalle.php
$pageTitle = 'Detalle del lugar';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Lugar.php';
require_once __DIR__ . '/../../models/Distrito.php';
require_once __DIR__ . '/../../models/Provincia.php';
require_once __DIR__ . '/../../models/Departamento.php';

// header + navbar
require_once view_path('views/templates/header.php');
require_once view_path('views/templates/navbar.php');

// Obtener id desde GET
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo "<div class='container py-5'><div class='alert alert-warning'>ID inválido. <a href='".BASE_URL."/index.php'>Volver al inicio</a></div></div>";
    require view_path('views/templates/footer.php');
    exit;
}

// Instanciamos modelos
$lugarModel = new Lugar();
$distritoModel = new Distrito();
$provinciaModel = new Provincia();
$departamentoModel = new Departamento();

// Obtener lugar
$lugar = $lugarModel->getById($id);
if (!$lugar) {
    echo "<div class='container py-5'><div class='alert alert-warning'>Lugar no encontrado. <a href='".BASE_URL."/index.php'>Volver al inicio</a></div></div>";
    require view_path('views/templates/footer.php');
    exit;
}

// Obtener distrito
$distrito = $distritoModel->getById($lugar['id_distrito']);
$distritoNombre = $distrito['nombre'] ?? 'Desconocido';

// Obtener provincia
$provincia = $provinciaModel->getById($distrito['id_provincia'] ?? 0);
$provinciaNombre = $provincia['nombre'] ?? 'Desconocida';

// Obtener departamento
$departamento = $departamentoModel->getById($provincia['id_departamento'] ?? 0);
$departamentoNombre = $departamento['nombre'] ?? 'Desconocido';

?>

<div class="container py-5">
    <h1 class="h3 mb-4"><?= htmlspecialchars($lugar['nombre']) ?></h1>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title">Descripción</h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($lugar['descripcion'])) ?></p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title">Información</h5>
            <p><strong>Tipo:</strong> <?= htmlspecialchars($lugar['tipo']) ?></p>
            <p><strong>Departamento:</strong> <?= htmlspecialchars($departamentoNombre) ?></p>
            <p><strong>Provincia:</strong> <?= htmlspecialchars($provinciaNombre) ?></p>
            <p><strong>Distrito:</strong> <?= htmlspecialchars($distritoNombre) ?></p>
            <p><strong>Coordenadas:</strong> <?= htmlspecialchars($lugar['latitud']) ?>, <?= htmlspecialchars($lugar['longitud']) ?></p>

            <a class="btn btn-outline-primary btn-sm mt-3" href="https://www.google.com/maps?q=<?= urlencode($lugar['latitud'] . ',' . $lugar['longitud']) ?>" target="_blank">Ver en Google Maps</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <iframe
                src="https://www.google.com/maps?q=<?= urlencode($lugar['latitud'] . ',' . $lugar['longitud']) ?>&output=embed"
                style="width:100%;height:300px;border:0;"
                allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

</div>

<?php
require view_path('views/templates/footer.php');
?>
