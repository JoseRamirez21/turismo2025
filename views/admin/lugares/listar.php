<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/LugarController.php';

$controller = new LugarController();

// Parámetros
$limit  = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Datos
$lugares = $controller->index($limit, $offset, $search);
$total = $controller->count($search);
$totalPages = ceil($total / $limit);

$pageTitle = "Lugares Turísticos";
require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php require view_path('views/admin/templates/sidebar.php'); ?>
    </div>

    <!-- Contenido -->
    <main class="col-md-9 col-lg-10 px-md-4 py-4">

      <!-- Encabezado -->
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary">
          <i class="bi bi-map-fill me-2 text-primary"></i> Lugares Turísticos
        </h2>

        <div class="d-flex align-items-center">
          <form method="GET" class="d-flex align-items-center me-2">
            <label for="limit" class="me-1 fw-semibold">Mostrar:</label>
            <select name="limit" id="limit" class="form-select form-select-sm me-2 w-auto" onchange="this.form.submit()">
              <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
              <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
              <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
              <option value="200" <?= $limit == 200 ? 'selected' : '' ?>>200</option>
            </select>

            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                   class="form-control form-control-sm me-2" placeholder="Buscar por nombre...">

            <button type="submit" class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="tooltip" title="Buscar">
              <i class="bi bi-search text-primary"></i>
            </button>
          </form>

          <a href="crear.php" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="tooltip" title="Nuevo lugar turístico">
            <i class="bi bi-plus-circle-fill"></i> Nuevo
          </a>
         
        </div>
      </div>

      <!-- Tabla -->
      <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle table-hover">
          <thead class="table-success text-dark">
            <tr>
              <th><i class="bi bi-hash"></i></th>
              <th><i class="bi bi-map-fill me-1"></i> Nombre</th>
              <th><i class="bi bi-tree-fill me-1"></i> Tipo</th>
              <th><i class="bi bi-geo-alt-fill me-1"></i> Distrito</th>
              <th class="text-center"><i class="bi bi-tools me-1"></i> Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($lugares): ?>
              <?php $i = $offset + 1; ?>
              <?php foreach ($lugares as $lugar): ?>
                <tr>
                  <td class="fw-semibold"><?= $i++ ?></td>
                  <td><i class="bi bi-map-fill text-warning me-1"></i> <?= htmlspecialchars($lugar['nombre']) ?></td>
                  <td><i class="bi bi-tree-fill text-success me-1"></i> <?= htmlspecialchars($lugar['tipo']) ?></td>
                  <td><i class="bi bi-geo-alt-fill text-primary me-1"></i> <?= htmlspecialchars($lugar['distrito_nombre'] ?? '—') ?></td>
                  <td class="text-center">
                    <!-- Editar -->
                    <a href="editar.php?id=<?= $lugar['id_lugar'] ?>" 
                       class="btn btn-sm btn-light me-2 shadow-sm icon-btn"
                       data-bs-toggle="tooltip" title="Editar">
                      <i class="bi bi-pencil-fill text-primary"></i>
                    </a>
                    <!-- Eliminar -->
                    <a href="#" 
                       class="btn btn-sm btn-light shadow-sm icon-btn"
                       data-bs-toggle="modal" 
                       data-bs-target="#deleteModal"
                       data-id="<?= $lugar['id_lugar'] ?>"
                       data-nombre="<?= htmlspecialchars($lugar['nombre']) ?>"
                       title="Eliminar">
                      <i class="bi bi-trash-fill text-danger"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="bi bi-inbox fs-4 text-secondary"></i><br>
                  No hay lugares registrados
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <?php if ($totalPages > 1): ?>
        <nav aria-label="Paginación">
          <ul class="pagination justify-content-center mt-3 flex-wrap">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
              <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $p ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>">
                  <?= $p ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>

    </main>
  </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">¿Seguro que deseas eliminar el lugar turístico <strong id="nombreLugar"></strong>?</p>
        <form id="deleteForm" method="POST" action="eliminar.php">
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
    document.getElementById('nombreLugar').textContent = nombre;
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
