<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/DistritoController.php';

$controller = new DistritoController();
$distritos = $controller->index();

$pageTitle = "Distritos";
require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>

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
        <h2 class="fw-bold text-warning">🏙️ Distritos</h2>
        <a href="crear.php" class="btn btn-success btn-sm">
          <i class="bi bi-plus-circle"></i> Nuevo
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
                  <th>Distrito</th>
                  <th>Provincia</th>
                  <th>Departamento</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($distritos): ?>
                  <?php foreach ($distritos as $d): ?>
                    <tr>
                      <td><?= htmlspecialchars($d['id_distrito']) ?></td>
                      <td><?= htmlspecialchars($d['nombre']) ?></td>
                      <td><?= htmlspecialchars($d['provincia_nombre'] ?? '—') ?></td>
                      <td><?= htmlspecialchars($d['departamento_nombre'] ?? '—') ?></td>
                      <td class="text-center">
                        <a href="editar.php?id=<?= $d['id_distrito'] ?>" class="btn btn-warning btn-sm me-1">
                          <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <a href="#"
                           class="btn btn-danger btn-sm"
                           data-bs-toggle="modal"
                           data-bs-target="#deleteModal"
                           data-id="<?= $d['id_distrito'] ?>"
                           data-nombre="<?= htmlspecialchars($d['nombre']) ?>">
                           <i class="bi bi-trash"></i> Eliminar
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted">No hay distritos registrados</td>
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
        <p class="mb-3">¿Seguro que deseas eliminar el distrito <strong id="nombreDistrito"></strong>?</p>
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
    document.getElementById('nombreDistrito').textContent = nombre;
  });
});
</script>
