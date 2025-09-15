<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/DepartamentoController.php';

// Obtener parámetros de búsqueda y página
$search = $_GET['search'] ?? '';
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit  = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

$controller = new DepartamentoController();
$result = $controller->index($search, $page, $limit);

$departamentos = $result['data'];
$total         = $result['total'];
$totalPages    = $result['totalPages'];
$currentPage   = $result['page'];

$pageTitle = "Departamentos";
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
          <i class="bi bi-building-fill-check me-2 text-primary"></i> Departamentos
        </h2>

        <div class="d-flex align-items-center">
          <form method="GET" class="d-flex align-items-center me-2">
            <label for="limit" class="me-1 fw-semibold">Mostrar:</label>
            <select name="limit" id="limit" class="form-select form-select-sm me-2 w-auto" onchange="this.form.submit()">
              <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
              <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
              <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
            </select>

            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
              class="form-control form-control-sm me-2" placeholder="Buscar...">
            <button type="submit" class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="tooltip" title="Buscar">
              <i class="bi bi-search text-primary"></i>
            </button>
          </form>

          <a href="crear.php" class="btn btn-primary btn-sm shadow-sm" data-bs-toggle="tooltip" title="Nuevo departamento">
            <i class="bi bi-plus-circle-fill"></i> Nuevo
          </a>
        </div>
      </div>

      <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle table-hover">
          <thead class="table-primary text-dark">
            <tr>
              <th scope="col"><i class="bi bi-hash"></i></th>
              <th scope="col"><i class="bi bi-card-text me-1"></i> Nombre</th>
              <th scope="col" class="text-center"><i class="bi bi-tools me-1"></i> Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($departamentos): ?>
              <?php $i = ($currentPage - 1) * $limit + 1; ?>
              <?php foreach ($departamentos as $d): ?>
                <tr>
                  <td class="fw-semibold"><?= $i++ ?></td>
                  <td><i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= htmlspecialchars($d['nombre']) ?></td>
                  <td class="text-center">
                    <!-- Botón Editar solo ícono -->
                    <a href="editar.php?id=<?= $d['id_departamento'] ?>" 
                       class="btn btn-sm btn-light me-2 shadow-sm icon-btn" 
                       data-bs-toggle="tooltip" 
                       data-bs-placement="top" 
                       title="Editar">
                      <i class="bi bi-pencil-fill text-primary"></i>
                    </a>
                    <!-- Botón Eliminar solo ícono -->
                    <a href="#" 
                       class="btn btn-sm btn-light shadow-sm icon-btn"
                       data-bs-toggle="modal" 
                       data-bs-target="#deleteModal" 
                       data-id="<?= $d['id_departamento'] ?>" 
                       data-nombre="<?= htmlspecialchars($d['nombre']) ?>" 
                       title="Eliminar">
                      <i class="bi bi-trash-fill text-danger"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-4">
                  <i class="bi bi-inbox fs-4 text-secondary"></i><br>
                  No hay departamentos registrados
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <?php if ($totalPages > 1): ?>
        <nav aria-label="Paginación">
          <ul class="pagination justify-content-center mt-3">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
              <li class="page-item <?= $p == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="?search=<?= urlencode($search) ?>&limit=<?= $limit ?>&page=<?= $p ?>">
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

<!-- Modal eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">¿Seguro que deseas eliminar el departamento <strong id="nombreDepartamento"></strong>?</p>
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
    document.getElementById('nombreDepartamento').textContent = nombre;
  });

  // Inicializar tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
</script>

<!-- Estilos extras -->
<style>
  .icon-btn i {
    font-size: 1.1rem;
    transition: transform 0.2s ease, color 0.2s ease;
  }
  .icon-btn:hover i {
    transform: scale(1.3);
  }
</style>
