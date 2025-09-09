<aside id="sidebar"
       class="d-flex flex-column flex-shrink-0 p-3 shadow"
       style="width:240px; background: linear-gradient(180deg, #0d6efd 0%, #182848 100%); color:white;">

  <!-- Logo -->
  <div class="text-center mb-4">
    <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logo"
         style="width:60px; margin-bottom:10px;">
    <h5 class="fw-bold mb-0">TURISMO PERÚ</h5>
    <small class="text-light">ADMIN</small>
  </div>

  <!-- Menú -->
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item mb-2">
      <a href="<?= BASE_URL ?>/views/admin/dashboard.php"
         class="nav-link text-white <?= basename($_SERVER['PHP_SELF'])=='dashboard.php' ? 'active' : '' ?>">
        <i class="bi bi-house-door me-2"></i> Inicio
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="<?= BASE_URL ?>/views/admin/departamentos/listar.php"
         class="nav-link text-white <?= strpos($_SERVER['PHP_SELF'],'departamentos')!==false ? 'active' : '' ?>">
        <i class="bi bi-geo-alt me-2"></i> Departamentos
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="<?= BASE_URL ?>/views/admin/provincias/listar.php"
         class="nav-link text-white <?= strpos($_SERVER['PHP_SELF'],'provincias')!==false ? 'active' : '' ?>">
        <i class="bi bi-map me-2"></i> Provincias
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="<?= BASE_URL ?>/views/admin/distritos/listar.php"
         class="nav-link text-white <?= strpos($_SERVER['PHP_SELF'],'distritos')!==false ? 'active' : '' ?>">
        <i class="bi bi-building me-2"></i> Distritos
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="<?= BASE_URL ?>/views/admin/lugares/listar.php"
         class="nav-link text-white <?= strpos($_SERVER['PHP_SELF'],'lugares')!==false ? 'active' : '' ?>">
        <i class="bi bi-camera me-2"></i> Lugares Turísticos
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="<?= BASE_URL ?>/views/admin/admins/listar.php"
         class="nav-link text-white <?= strpos($_SERVER['PHP_SELF'],'admins')!==false ? 'active' : '' ?>">
        <i class="bi bi-person-lines-fill me-2"></i> Administradores
      </a>
    </li>
  </ul>

  <!-- Logout abajo -->
  <div class="mt-auto">
    <a href="<?= BASE_URL ?>/views/admin/logout.php"
       class="btn btn-outline-light w-100 rounded-pill fw-bold">
      <i class="bi bi-box-arrow-right"></i> Cerrar sesión
    </a>
  </div>

  <!-- Estilos -->
  <style>
    #sidebar {
      min-height: 100%; /* Se adapta al contenido */
    }
    .nav-link {
      border-radius: 0.5rem;
      padding: 0.6rem 1rem;
      transition: background 0.3s;
    }
    .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.15);
    }
    .nav-link.active {
      background-color: rgba(255, 255, 255, 0.3);
      font-weight: 600;
    }
  </style>
</aside>
