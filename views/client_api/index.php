<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/ClientApiController.php';

$pageTitle = "Clientes API";

// Instanciar el controlador
$controller = new ClientApiController($pdo);
$clientes = $controller->index();

// Templates globales
require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3 col-lg-2 p-0">
      <?php require view_path('views/admin/templates/sidebar.php'); ?>
    </div>

    <main class="col-md-9 col-lg-10 px-md-4 py-4">
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary">
          <i class="bi bi-people-fill me-2 text-primary"></i> Clientes API
        </h2>

        <a href="create.php" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="tooltip" title="Nuevo cliente">
          <i class="bi bi-plus-circle-fill"></i> Nuevo
        </a>
      </div>

      <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle table-hover">
          <thead class="table-primary text-dark">
            <tr>
              <th scope="col"><i class="bi bi-hash"></i></th>
              <th scope="col"><i class="bi bi-person-vcard me-1"></i> DNI</th>
              <th scope="col"><i class="bi bi-person me-1"></i> Nombre</th>
              <th scope="col"><i class="bi bi-envelope-at me-1"></i> Correo</th>
              <th scope="col"><i class="bi bi-telephone me-1"></i> Teléfono</th>
              <th scope="col" class="text-center"><i class="bi bi-tools me-1"></i> Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($clientes): ?>
              <?php $i = 1; ?>
              <?php foreach ($clientes as $c): ?>
                <tr>
                  <td class="fw-semibold"><?= $i++ ?></td>
                  <td><?= htmlspecialchars($c['dni']) ?></td>
                  <td><?= htmlspecialchars($c['nombre']) . " " . htmlspecialchars($c['apellido']) ?></td>
                  <td><?= htmlspecialchars($c['correo']) ?></td>
                  <td><?= htmlspecialchars($c['telefono']) ?></td>
                  <td class="text-center">
                    <a href="edit.php?id=<?= $c['id'] ?>" 
                       class="btn btn-sm btn-light me-2 shadow-sm icon-btn" 
                       title="Editar">
                      <i class="bi bi-pencil-fill text-primary"></i>
                    </a>
                    
                    <a href="#" 
                       class="btn btn-sm btn-light shadow-sm icon-btn"
                       data-bs-toggle="modal" 
                       data-bs-target="#deleteModal" 
                       data-id="<?= $c['id'] ?>" 
                       data-nombre="<?= htmlspecialchars($c['nombre']) . " " . htmlspecialchars($c['apellido']) ?>" 
                       title="Eliminar">
                      <i class="bi bi-trash-fill text-danger"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-4">
                  <i class="bi bi-inbox fs-4 text-secondary"></i><br>
                  No hay clientes registrados
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

<!-- Modal eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">¿Seguro que deseas eliminar al cliente <strong id="nombreCliente"></strong>?</p>
        <form id="deleteForm" method="POST" action="delete.php">
          <input type="hidden" name="id" id="deleteId">
          <button type="submit" class="btn btn-danger shadow-sm">
            <i class="bi bi-trash-fill"></i> Sí, eliminar
          </button>
          <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">
            Cancelar
          </button>
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
    document.getElementById('nombreCliente').textContent = nombre;
  });

  // Inicializar tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
</script>

<style>
  .icon-btn i {
    font-size: 1.1rem;
    transition: transform 0.2s ease, color 0.2s ease;
  }
  .icon-btn:hover i {
    transform: scale(1.3);
  }
</style>
