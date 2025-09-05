<?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-dark bg-dark sticky-top px-3 shadow">
  <a class="navbar-brand fw-bold text-warning" href="<?= BASE_URL ?>/views/admin/dashboard.php">
    <img src="<?= asset('assets/img/logo.png') ?>" alt="Logo" width="30" class="me-2">
    <?= APP_NAME ?> - Admin
  </a>
  <div class="d-flex align-items-center text-white">
    <span class="me-3">👋 <?= htmlspecialchars($_SESSION['admin_nombre'] ?? 'Admin') ?></span>
    <a href="<?= BASE_URL ?>/views/admin/logout.php" class="btn btn-outline-light btn-sm">Salir</a>
  </div>
</nav>
