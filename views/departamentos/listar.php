<?php
$pageTitle = "Departamentos";
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Departamento.php';

// header + navbar
require_once view_path('views/templates/header.php');
require_once view_path('views/templates/navbar.php');

// Modelo
$departamentoModel = new Departamento();
$departamentos = $departamentoModel->getAll();
?>

<div class="container py-5">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
    <div>
      <h1 class="h3 mb-1">Departamentos del Perú</h1>
      <p class="text-muted mb-0">Explora los departamentos y navega hasta provincias, distritos y lugares turísticos.</p>
    </div>

    <div class="w-100 w-md-50">
      <input id="searchInput" class="form-control" placeholder="Buscar departamento (ej. Cusco, Lima...)">
    </div>
  </div>

  <div class="row" id="departamentosList">
    <?php if (empty($departamentos)): ?>
      <div class="col-12">
        <div class="alert alert-warning">No se encontraron departamentos.</div>
      </div>
    <?php else: ?>
      <?php foreach ($departamentos as $dep): ?>
        <div class="col-12 col-md-4 mb-4 departamento-card" data-name="<?= htmlspecialchars(mb_strtolower($dep['nombre'])) ?>">
          <div class="card h-100 shadow-sm border-0 rounded-3">
            <div class="card-body d-flex flex-column justify-content-between text-center">
              <div>
                <h5 class="card-title mb-2"><?= htmlspecialchars($dep['nombre']) ?></h5>
                <p class="small text-muted mb-3">Departamento</p>
              </div>
              <div class="mt-3">
                <a href="<?= BASE_URL ?>/views/provincias/listar.php?departamento_id=<?= intval($dep['id_departamento']) ?>" class="btn btn-primary btn-sm">Ver provincias</a>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('searchInput');
  input.addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    document.querySelectorAll('.departamento-card').forEach(card => {
      const name = card.getAttribute('data-name') || '';
      card.style.display = name.includes(q) ? '' : 'none';
    });
  });
});
</script>
