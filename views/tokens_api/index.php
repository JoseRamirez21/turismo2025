<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/TokensApiController.php';

// Verificar sesión de admin
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$controller = new TokensApiController($pdo);
$tokens = $controller->index();

$pageTitle = "Tokens API";
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
        <h2 class="fw-bold text-primary">
          <i class="bi bi-key me-2"></i> Tokens API
        </h2>
        <a href="create.php" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="tooltip" title="Nuevo token">
          <i class="bi bi-plus-circle-fill"></i> Nuevo
        </a>
      </div>

      <!-- Mensajes -->
      <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          Token eliminado correctamente.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          Ocurrió un error al procesar la acción.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Tabla -->
      <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle table-hover">
          <thead class="table-primary text-dark">
            <tr>
              <th scope="col"><i class="bi bi-hash"></i></th>
              <th scope="col"><i class="bi bi-person-badge me-1"></i> ID Cliente</th>
              <th scope="col"><i class="bi bi-key me-1"></i> Token</th>
              <th scope="col"><i class="bi bi-calendar-date me-1"></i> Fecha Registro</th>
              <th scope="col"><i class="bi bi-toggle-on me-1"></i> Estado</th>
              <th scope="col" class="text-center"><i class="bi bi-tools me-1"></i> Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($tokens)): ?>
              <?php $i = 1; ?>
              <?php foreach ($tokens as $t): 
                    $id = (int)$t['id'];
                    $idClient = htmlspecialchars($t['id_client_api']);
                    $tokenText = htmlspecialchars($t['token']);
                    $fecha = htmlspecialchars($t['fecha_registro']);
                    $estado = (int)$t['estado'] === 1 ? 'Activo' : 'Inactivo';
              ?>
                <tr>
                  <td class="fw-semibold"><?= $i++ ?></td>
                  <td><?= $idClient ?></td>
                  <td class="text-break" style="max-width: 250px;"><code><?= $tokenText ?></code></td>
                  <td><?= $fecha ?></td>
                  <td>
                    <?php if ($estado === 'Activo'): ?>
                      <span class="badge bg-success">Activo</span>
                    <?php else: ?>
                      <span class="badge bg-secondary">Inactivo</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <!-- Botón editar -->
                    <a href="edit.php?id=<?= $id ?>" 
                       class="btn btn-sm btn-light me-2 shadow-sm icon-btn" 
                       data-bs-toggle="tooltip" title="Editar">
                      <i class="bi bi-pencil-fill text-primary"></i>
                    </a>

                    <!-- Botón eliminar -->
                    <a href="#" 
                       class="btn btn-sm btn-light shadow-sm icon-btn"
                       data-bs-toggle="modal"
                       data-bs-target="#deleteModal"
                       data-id="<?= $id ?>"
                       data-token="<?= $tokenText ?>"
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
                  No hay tokens registrados aún.
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
        <h5 class="modal-title">
          <i class="bi bi-exclamation-triangle-fill"></i> Confirmar eliminación
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">¿Seguro que deseas eliminar el token <strong id="tokenNombre"></strong>?</p>
        <form id="deleteForm" method="POST" action="delete.php">
          <input type="hidden" name="id" id="deleteTokenId">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  var deleteModal = document.getElementById('deleteModal');
  if (deleteModal) {
    deleteModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');
      var token = button.getAttribute('data-token');
      document.getElementById('deleteTokenId').value = id;
      document.getElementById('tokenNombre').textContent = token;
    });
  }

  // Inicializar tooltips
  if (typeof bootstrap !== 'undefined') {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  }
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

<?php require view_path('views/admin/templates/footer.php'); ?>
