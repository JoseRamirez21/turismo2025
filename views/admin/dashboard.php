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

require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 text-light p-0">
      <?php require view_path('views/admin/templates/sidebar.php'); ?>
    </div>

    <!-- Contenido principal -->
    <main class="col-md-9 col-lg-10 px-md-4 py-4">

      <!-- Bienvenida -->
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary">👋 Bienvenido, <?= htmlspecialchars($adminNombre) ?></h2>
        <span class="text-muted">Panel de administración</span>
      </div>

      <!-- Tarjetas resumen ordenadas -->
     <!-- Tarjetas resumen ordenadas centradas -->
<div class="d-flex justify-content-center mb-4">
  <div class="row g-4" style="max-width:900px;">
    <?php 
    $cards = [
      ['title'=>'Departamentos','text'=>'Gestiona los departamentos registrados.','color'=>'primary','icon'=>'bi-geo-alt','link'=>'departamentos'],
      ['title'=>'Provincias','text'=>'Relaciona provincias con sus departamentos.','color'=>'success','icon'=>'bi-map','link'=>'provincias'],
      ['title'=>'Distritos','text'=>'Gestiona distritos vinculados a provincias.','color'=>'warning','icon'=>'bi-building','link'=>'distritos'],
      ['title'=>'Lugares','text'=>'Administra los lugares turísticos.','color'=>'info','icon'=>'bi-camera','link'=>'lugares'],
      ['title'=>'Administradores','text'=>'Gestiona los usuarios admin.','color'=>'danger','icon'=>'bi-person-lines-fill','link'=>'admins'],
    ];
    foreach($cards as $c): ?>
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-sm rounded-3 h-100 border-start border-4 border-<?= $c['color'] ?>">
        <div class="card-body d-flex flex-column align-items-start">
          <div class="d-flex align-items-center mb-2">
            <i class="bi <?= $c['icon'] ?> fs-3 text-<?= $c['color'] ?> me-2"></i>
            <h6 class="card-title mb-0"><?= $c['title'] ?></h6>
          </div>
          <p class="card-text small flex-grow-1"><?= $c['text'] ?></p>
          <a href="<?= BASE_URL ?>/views/admin/<?= $c['link'] ?>/listar.php" class="btn btn-<?= $c['color'] ?> btn-sm mt-auto <?= $c['color']=='info'?'text-white':'' ?>">Ver</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>


      <!-- Estadísticas más profesional -->
      
        

    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>

<!-- Scripts para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  .card-title { font-weight:600; }
  .card-text { color:#495057; }
  .border-start { border-left-width:4px !important; }
</style>
