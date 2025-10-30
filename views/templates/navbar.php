<?php require_once __DIR__ . '/../../config/config.php'; ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top shadow-sm">
  <div class="container">
    <!-- LOGO + NOMBRE -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= BASE_URL ?>/index.php">
      <img src="<?= asset('assets/img/logo.png') ?>" alt="Logo" class="logo-navbar">
      <span><?= APP_NAME ?></span>
    </a>

    <!-- BOTÓN RESPONSIVE -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENÚ -->
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/views/departamentos/listar.php">Departamentos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/views/provincias/listar.php">Provincias</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/views/distritos/listar.php">Distritos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/views/lugares/listar.php">Lugares</a></li>
      </ul>

   


      <!-- BOTÓN ADMIN (Separado del menú principal) -->
      <ul class="navbar-nav ms-lg-4 align-items-lg-center">
        <?php if (!isset($_SESSION['admin_id'])): ?>
          <li class="nav-item">
            <a class="btn btn-outline-warning rounded-pill px-4 py-1" href="<?= BASE_URL ?>/views/admin/login.php">
              Iniciar sesión
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item me-2">
            <span class="nav-link text-light">Hola, <?= htmlspecialchars($_SESSION['admin_nombre']) ?></span>
          </li>
          <li class="nav-item">
            <a class="btn btn-danger rounded-pill px-4 py-1" href="<?= BASE_URL ?>/views/admin/logout.php">Cerrar sesión</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
