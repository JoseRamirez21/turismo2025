<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/CountRequestController.php';
require_once __DIR__ . '/../../controllers/TokensApiController.php';

if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$controller = new CountRequestController($pdo);
$tokenController = new TokensApiController($pdo);
$tokens = $tokenController->index();


// Obtener ID
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: index.php');
    exit;
}

$countRequest = $controller->getRequestById($id);
if (!$countRequest) {
    header('Location: index.php');
    exit;
}


$errors = [];

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_token = $_POST['id_token'] ?? '';
    $tipo     = trim($_POST['tipo'] ?? '');

    if (empty($id_token)) $errors[] = "Debe seleccionar un token.";
    if (empty($tipo)) $errors[] = "El tipo es obligatorio.";

    if (empty($errors)) {
        $data = [
            'id_token' => $id_token,
            'tipo'     => $tipo
        ];
        if ($controller->update($id, $data)) {
            header("Location: index.php?updated=1");
            exit;
        } else {
            $errors[] = "Error al actualizar el count request.";
        }
    }
}

$pageTitle = "Editar Count Request";
require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3 col-lg-2 p-0">
      <?php require view_path('views/admin/templates/sidebar.php'); ?>
    </div>

    <main class="col-md-9 col-lg-10 px-md-4 py-4">

      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i> Editar Count Request</h2>
        <a href="index.php" class="btn btn-warning btn-sm shadow-sm">
          <i class="bi bi-arrow-left"></i> Volver
        </a>
      </div>

      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
          <form method="POST">

            <!-- Token -->
            <div class="mb-3">
              <label for="id_token" class="form-label fw-semibold"><i class="bi bi-key me-1"></i> Token</label>
              <select name="id_token" id="id_token" class="form-select" required>
                <option value="">-- Seleccionar token --</option>
                <?php foreach ($tokens as $t): ?>
                  <option value="<?= $t['id'] ?>" <?= ($countRequest['id_token'] == $t['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['token']) ?> (<?= htmlspecialchars($t['nombre'] . ' ' . $t['apellido']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Tipo -->
            <div class="mb-3">
              <label for="tipo" class="form-label fw-semibold"><i class="bi bi-card-text me-1"></i> Tipo</label>
              <input type="text" name="tipo" id="tipo" class="form-control" value="<?= htmlspecialchars($countRequest['tipo']) ?>" required>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary shadow-sm me-2">
                <i class="bi bi-check-circle me-1"></i> Actualizar
              </button>
              <a href="index.php" class="btn btn-outline-danger shadow-sm">
                <i class="bi bi-x-circle me-1"></i> Cancelar
              </a>
            </div>

          </form>
        </div>
      </div>

    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
