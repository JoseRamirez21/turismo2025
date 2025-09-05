<footer class="bg-dark text-light pt-4 mt-auto">
  <div class="container">
    <div class="row">
      <!-- Logo y descripción -->
      <div class="col-md-4 mb-3">
        <h5 class="fw-bold">Turismo Perú SAC</h5>
        <p class="small">
          Panel de administración del sistema turístico. 
          Gestiona departamentos, provincias, distritos y lugares turísticos del Perú.
        </p>
      </div>

      <!-- Enlaces rápidos -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">Accesos rápidos</h6>
        <ul class="list-unstyled small">
          <li><a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="text-light text-decoration-none">🏠 Dashboard</a></li>
          <li><a href="<?= BASE_URL ?>/views/admin/departamentos/listar.php" class="text-light text-decoration-none">📍 Departamentos</a></li>
          <li><a href="<?= BASE_URL ?>/views/admin/provincias/listar.php" class="text-light text-decoration-none">🗺️ Provincias</a></li>
          <li><a href="<?= BASE_URL ?>/views/admin/lugares/listar.php" class="text-light text-decoration-none">📸 Lugares turísticos</a></li>
        </ul>
      </div>

      <!-- Contacto -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">Contacto</h6>
        <p class="small mb-1">📧 soporte@turismoperu.com</p>
        <p class="small mb-1">📞 +51 987 654 321</p>
        <p class="small">📍 Lima, Perú</p>
      </div>
    </div>

    <hr class="border-light">

    <div class="text-center pb-3">
      <small>
        &copy; <?= date('Y') ?> <strong>Turismo Perú SAC</strong>. 
        Todos los derechos reservados.
      </small>
    </div>
  </div>
</footer>

<!-- Bootstrap Bundle con Popper -->
<script src="<?= asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>

