<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/ProvinciaController.php';

// Capturamos parámetros de búsqueda y paginación
$search = $_GET['search'] ?? '';
$limit  = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$controller = new ProvinciaController();
$provincias = $controller->index($search, $limit, $offset);
$total = $controller->count($search);
$totalPages = $limit > 0 ? ceil($total / $limit) : 1;

$pageTitle = "Provincias";
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

      <!-- Encabezado con búsqueda y límite -->
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-success">🗺️ Provincias</h2>

        <div class="d-flex align-items-center">
          <form method="GET" class="d-flex align-items-center me-2">
            <label for="limit" class="me-1">Mostrar:</label>
            <select name="limit" id="limit" class="form-select form-select-sm me-2 w-auto" onchange="this.form.submit()">
              <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
              <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
              <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
              <option value="200" <?= $limit == 200 ? 'selected' : '' ?>>200</option>
            </select>

            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                   class="form-control form-control-sm me-2" placeholder="Buscar por nombre...">

            <button type="submit" class="btn btn-sm btn-primary">
              <i class="bi bi-search"></i> Buscar
            </button>
          </form>

          <a href="crear.php" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Nueva
          </a>
        </div>
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
                  <?php $i = $offset + 1; ?>
                  <?php foreach ($provincias as $p): ?>
                    <tr>
                      <td><?= $i++ ?></td>
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

      <!-- Paginación -->
      <?php if ($totalPages > 1): ?>
        <nav class="mt-3">
          <ul class="pagination justify-content-center">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
              <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                <a class="page-link" href="?search=<?= urlencode($search) ?>&limit=<?= $limit ?>&page=<?= $p ?>"><?= $p ?></a>
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
