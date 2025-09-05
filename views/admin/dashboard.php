<?php
require_once __DIR__ . '/../../config/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el admin esté logueado
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$adminNombre = $_SESSION['admin_nombre'] ?? 'Administrador';
$pageTitle   = "Panel de Control";

// Header + topbar + sidebar
require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar (columna izquierda) -->
    <div class="col-md-3 col-lg-2 bg-dark text-light p-0">
      <?php require view_path('views/admin/templates/sidebar.php'); ?>
    </div>

    <!-- Contenido principal (columna derecha) -->
    <main class="col-md-9 col-lg-10 px-md-4 py-4">
      <!-- Bienvenida -->
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary">👋 Bienvenido, <?= htmlspecialchars($adminNombre) ?></h2>
        <span class="text-muted">Panel de administración</span>
      </div>

      <!-- Tarjetas resumen -->
      <div class="row g-4">
        <div class="col-md-3">
          <div class="card text-white bg-primary shadow rounded-3 h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Departamentos</h5>
              <p class="card-text small flex-grow-1">Gestiona los departamentos registrados.</p>
              <a href="<?= BASE_URL ?>/views/admin/departamentos/listar.php" class="btn btn-light btn-sm mt-auto">Ver más</a>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-white bg-success shadow rounded-3 h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Provincias</h5>
              <p class="card-text small flex-grow-1">Relaciona provincias con sus departamentos.</p>
              <a href="<?= BASE_URL ?>/views/admin/provincias/listar.php" class="btn btn-light btn-sm mt-auto">Ver más</a>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-dark bg-warning shadow rounded-3 h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Distritos</h5>
              <p class="card-text small flex-grow-1">Gestiona distritos vinculados a provincias.</p>
              <a href="<?= BASE_URL ?>/views/admin/distritos/listar.php" class="btn btn-dark btn-sm mt-auto">Ver más</a>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-white bg-info shadow rounded-3 h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Lugares</h5>
              <p class="card-text small flex-grow-1">Administra los lugares turísticos.</p>
              <a href="<?= BASE_URL ?>/views/admin/lugares/listar.php" class="btn btn-light btn-sm mt-auto">Ver más</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Segunda fila -->
      <div class="row g-4 mt-2">
        <div class="col-md-6">
          <div class="card text-white bg-danger shadow rounded-3 h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Administradores</h5>
              <p class="card-text small flex-grow-1">Gestiona los usuarios con permisos de administrador.</p>
              <a href="<?= BASE_URL ?>/views/admin/admins/listar.php" class="btn btn-light btn-sm mt-auto">Ver más</a>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card bg-light shadow rounded-3 h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Estadísticas</h5>
              <p class="card-text small flex-grow-1">Aquí podrás ver reportes y métricas del sistema.</p>
              <a href="#" class="btn btn-primary btn-sm mt-auto">Ver más</a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
