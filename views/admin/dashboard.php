<?php
require_once __DIR__ . '/../../config/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$adminNombre = $_SESSION['admin_nombre'] ?? 'Administrador';
$pageTitle   = "Panel de Control";

// === Instanciamos controladores ===
require_once __DIR__ . '/../../controllers/DepartamentoController.php';
require_once __DIR__ . '/../../controllers/ProvinciaController.php';
require_once __DIR__ . '/../../controllers/DistritoController.php';
require_once __DIR__ . '/../../controllers/LugarController.php';

$departamentoController = new DepartamentoController();
$provinciaController    = new ProvinciaController();
$distritoController     = new DistritoController();
$lugarController        = new LugarController();

// === Totales desde BD ===
$totalDepartamentos = $departamentoController->count('');
$totalProvincias    = $provinciaController->count('');
$totalDistritos     = $distritoController->count('');
$totalLugares       = $lugarController->count('');

require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>

<div class="container-fluid">
  <div class="row">
    <!-- ===== SIDEBAR ===== -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php require view_path('views/admin/templates/sidebar.php'); ?>
    </div>

    <!-- ===== CONTENIDO PRINCIPAL ===== -->
    <main class="col-md-9 col-lg-10 px-md-4 py-4">
      
      <!-- Encabezado -->
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary">👋 Bienvenido, <?= htmlspecialchars($adminNombre) ?></h2>
        <span class="text-muted">Panel de administración</span>
      </div>

      <!-- Tarjetas estadísticas -->
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="card shadow-sm border-0 h-100 bg-primary text-white">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-geo-alt-fill fs-2 me-3"></i>
              <div>
                <h6 class="mb-0">Departamentos</h6>
                <h4 class="fw-bold"><?= $totalDepartamentos ?></h4>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm border-0 h-100 bg-success text-white">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-building fs-2 me-3"></i>
              <div>
                <h6 class="mb-0">Provincias</h6>
                <h4 class="fw-bold"><?= $totalProvincias ?></h4>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm border-0 h-100 bg-warning text-dark">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-map fs-2 me-3"></i>
              <div>
                <h6 class="mb-0">Distritos</h6>
                <h4 class="fw-bold"><?= $totalDistritos ?></h4>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card shadow-sm border-0 h-100 bg-danger text-white">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-tree-fill fs-2 me-3"></i>
              <div>
                <h6 class="mb-0">Lugares Turísticos</h6>
                <h4 class="fw-bold"><?= $totalLugares ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla de resumen rápido -->
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-gradient text-white fw-bold" style="background: linear-gradient(90deg, #2563eb, #1d4ed8);">
          📊 Resumen General
        </div>
        <div class="card-body p-0">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th scope="col" class="text-center">Entidad</th>
                <th scope="col" class="text-center">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="d-flex align-items-center">
                  <span class="badge bg-primary rounded-circle p-2 me-2">
                    <i class="bi bi-geo-alt-fill"></i>
                  </span>
                  <span class="fw-semibold">Departamentos</span>
                </td>
                <td class="text-center fw-bold text-primary"><?= $totalDepartamentos ?></td>
              </tr>
              <tr>
                <td class="d-flex align-items-center">
                  <span class="badge bg-success rounded-circle p-2 me-2">
                    <i class="bi bi-building"></i>
                  </span>
                  <span class="fw-semibold">Provincias</span>
                </td>
                <td class="text-center fw-bold text-success"><?= $totalProvincias ?></td>
              </tr>
              <tr>
                <td class="d-flex align-items-center">
                  <span class="badge bg-warning rounded-circle p-2 me-2">
                    <i class="bi bi-map"></i>
                  </span>
                  <span class="fw-semibold">Distritos</span>
                </td>
                <td class="text-center fw-bold text-warning"><?= $totalDistritos ?></td>
              </tr>
              <tr>
                <td class="d-flex align-items-center">
                  <span class="badge bg-danger rounded-circle p-2 me-2">
                    <i class="bi bi-tree-fill"></i>
                  </span>
                  <span class="fw-semibold">Lugares Turísticos</span>
                </td>
                <td class="text-center fw-bold text-danger"><?= $totalLugares ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Botón de acceso a gestión de clientes -->
      <div class="text-center mt-4">
        <a href="<?= BASE_URL ?>/views/client_api/index.php" class="btn btn-outline-primary btn-lg shadow-sm">
          👥 Ir a Gestión de Clientes
        </a>
      </div>

    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
