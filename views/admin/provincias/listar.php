<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/ProvinciaController.php';

$controller = new ProvinciaController();
$provincias = $controller->index();

$pageTitle = "Provincias";
require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>
<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php require view_path('views/admin/templates/sidebar.php'); ?>
    </div>

    <!-- Contenido principal -->
    <main class="col-md-9 col-lg-10 px-md-4 py-4">

      <!-- Encabezado -->
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-success">🗺️ Provincias</h2>
        <a href="crear.php" class="btn btn-success btn-sm">
          <i class="bi bi-plus-circle"></i> Nueva
        </a>
      </div>

      <!-- Tabla -->
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-dark">
                <tr>
                  <th>#</th>
                  <th>Provincia</th>
                  <th>Departamento</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
            <tbody>
  <?php if ($provincias): ?>
    <?php $i = 1; // contador manual ?>
    <?php foreach ($provincias as $p): ?>
      <tr>
        <td><?= $i++ ?></td> <!-- contador desde 1 -->
        <td><?= htmlspecialchars($p['nombre']) ?></td>
        <td><?= htmlspecialchars($p['departamento_nombre'] ?? '—') ?></td>
        <td class="text-center">
          <a href="editar.php?id=<?= $p['id_provincia'] ?>" class="btn btn-warning btn-sm me-2">
            <i class="bi bi-pencil-square"></i> Editar
          </a>
          <a href="#" 
             class="btn btn-danger btn-sm"
             data-bs-toggle="modal" 
             data-bs-target="#deleteModal"
             data-id="<?= $p['id_provincia'] ?>"
             data-nombre="<?= htmlspecialchars($p['nombre']) ?>">
             <i class="bi bi-trash"></i> Eliminar
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="4" class="text-center text-muted">No hay provincias registradas</td>
    </tr>
  <?php endif; ?>
</tbody>

            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">¿Seguro que deseas eliminar la provincia <strong id="nombreProvincia"></strong>?</p>
        <form id="deleteForm" method="POST" action="eliminar.php">
          <input type="hidden" name="id" id="deleteId">
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Sí, eliminar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var nombre = button.getAttribute('data-nombre');
    document.getElementById('deleteId').value = id;
    document.getElementById('nombreProvincia').textContent = nombre;
  });
});
</script>
