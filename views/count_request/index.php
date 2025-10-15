<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/CountRequestController.php';
require_once __DIR__ . '/../../controllers/TokensApiController.php';

// Verificar sesión de admin
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$controller = new CountRequestController($pdo);
$tokenController = new TokensApiController($pdo);

// Obtener todos los registros
$countRequests = $controller->index();

// Traer tokens para mostrar cliente + token
$tokens = $tokenController->index();


$pageTitle = "Count Requests";
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
          <i class="bi bi-card-checklist me-2"></i> Count Requests
        </h2>
        <a href="create.php" class="btn btn-primary btn-sm shadow-sm">
          <i class="bi bi-plus-circle-fill"></i> Nuevo
        </a>
      </div>

      <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle table-hover">
          <thead class="table-primary text-dark">
            <tr>
              <th>#</th>
              <th>ID Token</th>
              <th>Cliente</th>
              <th>Token</th>
              <th>Tipo</th>
              <th>Fecha</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($countRequests)): ?>
              <?php $i = 1; ?>
              <?php foreach ($countRequests as $c): 
                  $id = (int)$c['id'];
                  $idToken = (int)$c['id_token'];
                  $tipo = htmlspecialchars($c['tipo']);
                  $fecha = htmlspecialchars($c['fecha']);
                  
                  // Buscar token y cliente
                  $tokenInfo = array_filter($tokens, fn($t) => $t['id'] == $idToken);
                  $tokenInfo = array_values($tokenInfo);
                  $tokenText = $tokenInfo[0]['token'] ?? 'Token no encontrado';
                  $cliente = $tokenInfo[0]['nombre'] ?? 'Cliente';
                  $apellido = $tokenInfo[0]['apellido'] ?? '';
              ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><?= $idToken ?></td>
                  <td><?= htmlspecialchars($cliente . ' ' . $apellido) ?></td>
                  <td class="text-break" style="max-width: 250px;"><code><?= htmlspecialchars($tokenText) ?></code></td>
                  <td><?= $tipo ?></td>
                  <td><?= $fecha ?></td>
                  <td class="text-center">
                    <a href="edit.php?id=<?= $id ?>" class="btn btn-sm btn-light me-2 shadow-sm">
                      <i class="bi bi-pencil-fill text-primary"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-light shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $id ?>" data-tipo="<?= $tipo ?>">
                      <i class="bi bi-trash-fill text-danger"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="bi bi-inbox fs-4 text-secondary"></i><br>
                  No hay registros de count request.
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
        <p class="mb-3">¿Seguro que deseas eliminar el registro <strong id="tipoNombre"></strong>?</p>
        <form id="deleteForm" method="POST" action="delete.php">
          <input type="hidden" name="id" id="deleteId">
          <button type="submit" class="btn btn-danger shadow-sm">
            <i class="bi bi-trash-fill"></i> Sí, eliminar
          </button>
          <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
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
        <p class="mb-3">¿Seguro que deseas eliminar el registro <strong id="requestTipo"></strong>?</p>
        <form id="deleteForm" method="POST" action="delete.php">
          <input type="hidden" name="id" id="deleteRequestId">
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
      var tipo = button.getAttribute('data-tipo');
      document.getElementById('deleteRequestId').value = id;
      document.getElementById('requestTipo').textContent = tipo;
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


<script>
document.addEventListener('DOMContentLoaded', function () {
  var deleteModal = document.getElementById('deleteModal');
  if (deleteModal) {
    deleteModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');
      var tipo = button.getAttribute('data-tipo');
      document.getElementById('deleteId').value = id;
      document.getElementById('tipoNombre').textContent = tipo;
    });
  }
});
</script>

<?php require view_path('views/admin/templates/footer.php'); ?>
