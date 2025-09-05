<?php require_once __DIR__ . '/../../config/config.php'; ?>
<footer class="footer-custom mt-5">
  <div class="container py-5">
    <div class="row g-4">
      <!-- Logo y descripción -->
      <div class="col-12 col-md-4">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="<?= asset('assets/img/logo.png') ?>" alt="Logo" class="logo-footer">
          <h5 class="m-0 text-white"><?= APP_NAME ?></h5>
        </div>
        <p class="small text-light">
          <?= APP_NAME ?> es un portal de turismo del Perú. Explora departamentos, provincias, distritos y sus principales atractivos.
        </p>
      </div>

      <!-- Navegación -->
      <div class="col-6 col-md-4">
        <h6 class="text-uppercase text-footer mb-3">Explorar</h6>
        <ul class="list-unstyled small">
          <li><a class="footer-link" href="<?= BASE_URL ?>/views/departamentos/listar.php">Departamentos</a></li>
          <li><a class="footer-link" href="<?= BASE_URL ?>/views/provincias/listar.php">Provincias</a></li>
          <li><a class="footer-link" href="<?= BASE_URL ?>/views/distritos/listar.php">Distritos</a></li>
          <li><a class="footer-link" href="<?= BASE_URL ?>/views/lugares/listar.php">Lugares</a></li>
        </ul>
      </div>

      <!-- Contacto -->
      <div class="col-6 col-md-4">
        <h6 class="text-uppercase text-footer mb-3">Contacto</h6>
        <ul class="list-unstyled small text-light">
          <li><i class="bi bi-envelope"></i> info@tudominio.com</li>
          <li><i class="bi bi-telephone"></i> +51 999 999 999</li>
          <li><i class="bi bi-geo-alt"></i> Lima, Perú</li>
        </ul>
        <div class="d-flex gap-3 mt-2">
          <a href="#" class="footer-social"><i class="bi bi-facebook"></i></a>
          <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
          <a href="#" class="footer-social"><i class="bi bi-twitter"></i></a>
        </div>
      </div>
    </div>
    <div class="text-center mt-4">
      <p class="small text-light mb-0">© <?= date('Y') ?> <?= APP_NAME ?> · Todos los derechos reservados</p>
    </div>
  </div>
</footer>

<script src="<?= asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.bundle.min.js') ?>"></script>
<script type="module" src="<?= asset('assets/js/main.js') ?>"></script>

</body>
</html>
