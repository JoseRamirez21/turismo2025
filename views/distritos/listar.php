<?php
// views/distritos/listar.php
$pageTitle = "Distritos";
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Distrito.php';
require_once __DIR__ . '/../../models/Provincia.php';

// header + navbar
require_once view_path('views/templates/header.php');
require_once view_path('views/templates/navbar.php');

// Parámetro GET
$provinciaId = intval($_GET['provincia_id'] ?? 0);
$distritoModel = new Distrito();
$provinciaModel = new Provincia();

// Validar provincia
$provincia = $provinciaModel->getById($provinciaId);
if (!$provincia) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Provincia no encontrada. <a href='" . BASE_URL . "/views/departamentos/listar.php'>Volver</a></div></div>";
    require view_path('views/templates/footer.php');
    exit;
}

$distritos = $distritoModel->getByProvincia($provinciaId);
?>

<div class="container py-5">
  <h1 class="h3 mb-4">Distritos de <?= htmlspecialchars($provincia['nombre']) ?></h1>

  <div class="row">
    <?php if (empty($distritos)): ?>
      <div class="col-12">
        <div class="alert alert-warning">No hay distritos registrados para esta provincia.</div>
      </div>
    <?php else: ?>
      <?php foreach ($distritos as $dist): ?>
        <div class="col-12 col-md-4 mb-4">
          <div class="card h-100 shadow-sm border-0 text-center">
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h5 class="card-title"><?= htmlspecialchars($dist['nombre']) ?></h5>
                <p class="small text-muted mb-3">Distrito</p>
              </div>
              <div>
                <a href="<?= BASE_URL ?>/views/lugares/listar.php?distrito_id=<?= intval($dist['id_distrito']) ?>" class="btn btn-primary btn-sm">Ver lugares turísticos</a>
              </div>
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
