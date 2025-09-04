<?php
// views/lugares/listar.php
$pageTitle = "Lugares Turísticos";
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Lugar.php';
require_once __DIR__ . '/../../models/Distrito.php';

// header + navbar
require_once view_path('views/templates/header.php');
require_once view_path('views/templates/navbar.php');

// Parámetro GET
$distritoId = intval($_GET['distrito_id'] ?? 0);
$lugarModel = new Lugar();
$distritoModel = new Distrito();

// Validar distrito
$distrito = $distritoModel->getById($distritoId);
if (!$distrito) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Distrito no encontrado. <a href='" . BASE_URL . "/views/departamentos/listar.php'>Volver</a></div></div>";
    require view_path('views/templates/footer.php');
    exit;
}

// Obtener lugares del distrito
$lugares = $lugarModel->getByDistrito($distritoId);
?>

<div class="container py-5">
  <h1 class="h3 mb-4">Lugares turísticos en <?= htmlspecialchars($distrito['nombre']) ?></h1>

  <div class="row">
    <?php if (empty($lugares)): ?>
      <div class="col-12">
        <div class="alert alert-warning">No hay lugares registrados para este distrito.</div>
      </div>
    <?php else: ?>
      <?php foreach ($lugares as $lugar): ?>
        <div class="col-12 col-md-4 mb-4">
          <div class="card h-100 shadow-sm border-0">
            <!-- Imagen por defecto -->
            <img src="<?= asset('assets/img/default.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($lugar['nombre']) ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($lugar['nombre']) ?></h5>
              <p class="card-text text-muted small flex-grow-1">
                <?= htmlspecialchars(substr($lugar['descripcion'], 0, 100)) ?>...
              </p>
              <a href="<?= BASE_URL ?>/views/lugares/detalle.php?id=<?= intval($lugar['id_lugar']) ?>" class="btn btn-outline-primary btn-sm mt-auto">Ver detalle</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php
require_once view_path('views/templates/footer.php');
?>
