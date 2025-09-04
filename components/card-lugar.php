<?php
require_once __DIR__ . '/../config/config.php';

function card_lugar(array $opts = []): void {
  $img       = $opts['img']       ?? asset('assets/img/lugares/placeholder.jpg');
  $titulo    = $opts['titulo']    ?? 'Lugar turístico';
  $subtitulo = $opts['subtitulo'] ?? '';
  $link      = $opts['link']      ?? '#';
  ?>
  <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
      <img src="<?= htmlspecialchars($img) ?>" class="card-img-top object-fit-cover" alt="<?= htmlspecialchars($titulo) ?>" style="height:220px">
      <div class="card-body">
        <h5 class="card-title mb-1"><?= htmlspecialchars($titulo) ?></h5>
        <?php if ($subtitulo): ?>
          <p class="text-muted small mb-3"><?= htmlspecialchars($subtitulo) ?></p>
        <?php endif; ?>
        <a class="btn btn-primary btn-sm" href="<?= htmlspecialchars($link) ?>">Ver más</a>
      </div>
    </div>
  </div>
  <?php
}
