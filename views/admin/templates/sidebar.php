<aside id="sidebar" class="d-flex flex-column vh-100 shadow"
       style="width:240px; background: linear-gradient(180deg, #0d6efd 0%, #1a2e8a 100%); color:white;">

  <!-- Logo -->
  <div class="p-3 border-bottom border-light">
    <h5 class="fw-bold text-center mb-0">🌐 TURISMO PERÚ SAC</h5>
    <small class="d-block text-center text-light">ADMIN</small>
  </div>

  <!-- Menú -->
  <nav class="flex-grow-1 p-3">
    <h6 class="text-uppercase text-light small fw-bold mb-3">Menú</h6>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="nav-link text-white">
          <i class="bi bi-house-door me-2"></i> Inicio
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/departamentos/listar.php" class="nav-link text-white">
          <i class="bi bi-geo-alt me-2"></i> Departamentos
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/provincias/listar.php" class="nav-link text-white">
          <i class="bi bi-map me-2"></i> Provincias
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/distritos/listar.php" class="nav-link text-white">
          <i class="bi bi-building me-2"></i> Distritos
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= BASE_URL ?>/views/admin/lugares/listar.php" class="nav-link text-white">
          <i class="bi bi-camera me-2"></i> Lugares Turísticos
        </a>
      </li>
    </ul>
  </nav>

  <!-- Logout -->
  <div class="p-3 border-top border-light">
    <a href="<?= BASE_URL ?>/views/admin/logout.php"
       class="btn btn-outline-light w-100 rounded-pill fw-bold">
      <i class="bi bi-box-arrow-right"></i> Cerrar sesión
    </a>
  </div>
</aside>
