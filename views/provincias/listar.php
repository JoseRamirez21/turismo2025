<?php
// views/provincias/listar.php
$pageTitle = "Provincias";
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Provincia.php';
require_once __DIR__ . '/../../models/Departamento.php';

// header + navbar
require_once view_path('views/templates/header.php');
require_once view_path('views/templates/navbar.php');

// Parámetro GET
$departamentoId = intval($_GET['departamento_id'] ?? 0);

$provinciaModel = new Provincia();
$departamentoModel = new Departamento();

// Validar departamento
$departamento = $departamentoModel->getById($departamentoId);
if (!$departamento) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Departamento no encontrado. <a href='" . BASE_URL . "/views/departamentos/listar.php'>Volver</a></div></div>";
    require_once view_path('views/templates/footer.php'); // ✅ usar require_once
    exit;
}

// Obtener provincias del departamento
$provincias = $provinciaModel->getByDepartamento($departamentoId);
?>

<div class="container py-5">
  <h1 class="h3 mb-4">Provincias de <?= htmlspecialchars($departamento['nombre']) ?></h1>

  <div class="row">
    <?php if (empty($provincias)): ?>
      <div class="col-12">
        <div class="alert alert-warning">No hay provincias registradas para este departamento.</div>
      </div>
    <?php else: ?>
      <?php foreach ($provincias as $prov): ?>
        <div class="col-12 col-md-4 mb-4">
          <div class="card h-100 shadow-sm border-0 text-center">
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h5 class="card-title"><?= htmlspecialchars($prov['nombre']) ?></h5>
                <p class="small text-muted mb-3">Provincia</p>
              </div>
              <div>
                <a href="<?= BASE_URL ?>/views/distritos/listar.php?provincia_id=<?= intval($prov['id_provincia']) ?>" class="btn btn-primary btn-sm">Ver distritos</a>
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
