<?php require_once __DIR__ . '/../../config/config.php'; ?>
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
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/views/departamentos/listar.php">Departamentos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/views/provincias/listar.php">Provincias</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/views/distritos/listar.php">Distritos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/views/lugares/listar.php">Lugares</a></li>
      </ul>
    </div>
  </div>
</nav>
