<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/TokensApiController.php';
require_once __DIR__ . '/../../controllers/ClientApiController.php';

if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

$controller = new TokensApiController($pdo);
$clientController = new ClientApiController($pdo);
$clients = $clientController->index();

// Obtener ID del token
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: index.php');
    exit;
}

$tokenData = $controller->getTokenById($id);
if (!$tokenData) {
    header('Location: index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client_api = $_POST['id_client_api'] ?? '';
    $token = trim($_POST['token'] ?? '');
    $estado = $_POST['estado'] ?? 1;

    if (empty($id_client_api) || $token === '' || ($estado !== '0' && $estado !== '1')) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    if (empty($errors)) {
        if ($controller->update($id, [
            'id_client_api' => $id_client_api,
            'token'         => $token,
            'estado'        => $estado
        ])) {
            // Redirigir al index después de actualizar
            header('Location: index.php?updated=1');
            exit;
        } else {
            $errors[] = "Error al actualizar el token.";
        }
    }
}

$pageTitle = "Editar Token API";
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
        <h2 class="fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i> Editar Token API</h2>
        <a href="index.php" class="btn btn-warning btn-sm">
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

      <div class="card shadow-sm">
        <div class="card-body">
          <form method="POST">

            <div class="mb-3">
              <label for="id_client_api" class="form-label fw-bold">Cliente</label>
              <select name="id_client_api" id="id_client_api" class="form-select" required>
                <option value="">-- Seleccione un cliente --</option>
                <?php foreach ($clients as $c): ?>
                  <option value="<?= $c['id'] ?>" <?= ($c['id'] == ($id_client_api ?? $tokenData['id_client_api'])) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre'] . ' ' . $c['apellido']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="token" class="form-label fw-bold">Token</label>
              <input type="text" name="token" id="token" class="form-control"
                     value="<?= htmlspecialchars($_POST['token'] ?? $tokenData['token']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="estado" class="form-label fw-bold">Estado</label>
              <select name="estado" id="estado" class="form-select" required>
                <option value="1" <?= (($estado ?? $tokenData['estado']) == 1) ? 'selected' : '' ?>>Activo</option>
                <option value="0" <?= (($estado ?? $tokenData['estado']) == 0) ? 'selected' : '' ?>>Inactivo</option>
              </select>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary me-2">
                <i class="bi bi-check-circle me-1"></i> Actualizar
              </button>
              <a href="index.php" class="btn btn-outline-danger">
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
