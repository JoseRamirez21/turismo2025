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
      
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary">👋 Bienvenido, <?= htmlspecialchars($adminNombre) ?></h2>
        <span class="text-muted">Panel de administración</span>
      </div>

      <!-- Aquí va tu contenido, ejemplo: listado de departamentos -->
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Listado de Departamentos</h5>
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Aquí recorres tus datos desde la BD -->
              <tr>
                <td>1</td>
                <td>Lima</td>
                <td>
                  <a href="#" class="btn btn-sm btn-warning">Editar</a>
                  <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
