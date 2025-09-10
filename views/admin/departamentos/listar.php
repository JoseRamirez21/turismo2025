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
        <h2 class="fw-bold text-primary">📍 Departamentos</h2>

        <div class="d-flex align-items-center">
          <form method="GET" class="d-flex align-items-center me-2">
            <label for="limit" class="me-1">Mostrar:</label>
            <select name="limit" id="limit" class="form-select form-select-sm me-2 w-auto" onchange="this.form.submit()">
              <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
              <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
              <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
            </select>

            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control form-control-sm me-2" placeholder="Buscar...">
            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Buscar</button>
          </form>

          <a href="crear.php" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Nuevo
          </a>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-dark">
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($departamentos): ?>
                  <?php $i = ($currentPage - 1) * $limit + 1; ?>
                  <?php foreach ($departamentos as $d): ?>
                    <tr>
                      <td><?= $i++ ?></td>
                      <td><?= htmlspecialchars($d['nombre']) ?></td>
                      <td class="text-center">
                        <a href="editar.php?id=<?= $d['id_departamento'] ?>" class="btn btn-warning btn-sm me-2">
                          <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $d['id_departamento'] ?>" data-nombre="<?= htmlspecialchars($d['nombre']) ?>">
                          <i class="bi bi-trash"></i> Eliminar
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="3" class="text-center text-muted">No hay departamentos registrados</td>
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
                    <a class="page-link" href="?search=<?= urlencode($search) ?>&limit=<?= $limit ?>&page=<?= $p ?>"><?= $p ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Modal eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-3">¿Seguro que deseas eliminar el departamento <strong id="nombreDepartamento"></strong>?</p>
        <form id="deleteForm" method="POST" action="eliminar.php">
          <input type="hidden" name="id" id="deleteId">
          <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Sí, eliminar</button>
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
    document.getElementById('nombreDepartamento').textContent = nombre;
  });
});
</script>
