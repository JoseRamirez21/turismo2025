<aside id="sidebar" class="d-flex flex-column shadow"
       style="width:240px; background: linear-gradient(180deg, #0d6efd 0%, #1a2e8a 100%); color:white; min-height:0;">

  <!-- Logo -->
  <div class="p-3 border-bottom border-light text-center">
    <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logo" style="width:60px; margin-bottom:10px;">
    <h5 class="fw-bold mb-0">TURISMO PERÚ</h5>
    <small class="text-light">ADMIN</small>
  </div>

  <!-- Menú -->
  <nav class="flex-grow-1 p-3 d-flex flex-column justify-content-between" style="min-height:0;">
    <ul class="nav flex-column mb-3">
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/dashboard.php"
           class="nav-link text-white sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
          <i class="bi bi-house-door me-2"></i> Inicio
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/departamentos/listar.php"
           class="nav-link text-white sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'listar.php' && strpos($_SERVER['PHP_SELF'], 'departamentos') !== false ? 'active' : '' ?>">
          <i class="bi bi-geo-alt me-2"></i> Departamentos
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/provincias/listar.php"
           class="nav-link text-white sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'listar.php' && strpos($_SERVER['PHP_SELF'], 'provincias') !== false ? 'active' : '' ?>">
          <i class="bi bi-map me-2"></i> Provincias
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/distritos/listar.php"
           class="nav-link text-white sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'listar.php' && strpos($_SERVER['PHP_SELF'], 'distritos') !== false ? 'active' : '' ?>">
          <i class="bi bi-building me-2"></i> Distritos
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/lugares/listar.php"
           class="nav-link text-white sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'listar.php' && strpos($_SERVER['PHP_SELF'], 'lugares') !== false ? 'active' : '' ?>">
          <i class="bi bi-camera me-2"></i> Lugares Turísticos
        </a>
      </li>
    </ul>

    <!-- Logout -->
    <div class="mt-auto p-3">
      <a href="<?= BASE_URL ?>/views/admin/logout.php"
         class="btn btn-outline-light w-100 rounded-pill fw-bold">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
      </a>
    </div>
  </nav>

  <!-- Estilos internos del sidebar -->
  <style>
    /* Hover suave en los enlaces */
    .sidebar-link:hover {
      background-color: rgba(255, 255, 255, 0.15);
      border-radius: 0.5rem;
      transition: all 0.3s;
    }

    /* Enlace activo */
    .sidebar-link.active {
      background-color: rgba(255, 255, 255, 0.3);
      font-weight: 600;
      border-radius: 0.5rem;
    }

    /* Scroll en sidebar si hay muchos elementos */
    #sidebar {
      overflow-y: auto;
      min-height:0;
    }
  </style>
</aside>
