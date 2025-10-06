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

// ✅ Actualizar estado (único campo editable)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id_client_api = $_POST['id_client_api'] ?? '';
    $estado = $_POST['estado'] ?? '1';

    if (empty($id_client_api) || ($estado !== '0' && $estado !== '1')) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    if (empty($errors)) {
        if ($controller->update($id, [
            'id_client_api' => $id_client_api,
            'token'         => $tokenData['token'], // No editable
            'estado'        => $estado
        ])) {
            header('Location: index.php?updated=1');
            exit;
        } else {
            $errors[] = "Error al actualizar el token.";
        }
    }
}

// ✅ Regenerar token
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_token'])) {
    $nuevoToken = bin2hex(random_bytes(16)) . '-' . $tokenData['id_client_api'];

    if ($controller->update($id, [
        'id_client_api' => $tokenData['id_client_api'],
        'token'         => $nuevoToken,
        'estado'        => $tokenData['estado']
    ])) {
        header('Location: edit.php?id=' . $id . '&regenerated=1');
        exit;
    } else {
        $errors[] = "Error al generar un nuevo token.";
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

      <?php if (isset($_GET['regenerated']) && $_GET['regenerated'] == 1): ?>
        <div class="alert alert-success">
          <i class="bi bi-check-circle"></i> Token regenerado correctamente.
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-body">
          <!-- Formulario de actualización -->
          <form method="POST">

            <!-- ✅ Cliente (solo lectura) -->
            <div class="mb-3">
              <label class="form-label fw-bold">Cliente</label>
              <?php
                $clienteNombre = 'Cliente no encontrado';
                foreach ($clients as $c) {
                    if ($c['id'] == $tokenData['id_client_api']) {
                        $clienteNombre = htmlspecialchars($c['nombre'] . ' ' . $c['apellido']);
                        break;
                    }
                }
              ?>
              <input type="text" class="form-control" value="<?= $clienteNombre ?>" readonly>
              <input type="hidden" name="id_client_api" value="<?= htmlspecialchars($tokenData['id_client_api']) ?>">
            </div>

            <!-- ✅ Token (solo lectura) -->
            <div class="mb-3">
              <label for="token" class="form-label fw-bold">Token</label>
              <input type="text" name="token" id="token" class="form-control"
                     value="<?= htmlspecialchars($tokenData['token']) ?>" readonly>
              <small class="text-muted">Este token no puede editarse manualmente.</small>
            </div>

            <!-- ✅ Estado -->
            <div class="mb-3">
              <label for="estado" class="form-label fw-bold">Estado</label>
              <select name="estado" id="estado" class="form-select" required>
                <option value="1" <?= ($tokenData['estado'] == 1) ? 'selected' : '' ?>>Activo</option>
                <option value="0" <?= ($tokenData['estado'] == 0) ? 'selected' : '' ?>>Inactivo</option>
              </select>
            </div>

            <!-- ✅ Botones -->
            <div class="d-flex justify-content-end mt-4">
              <button type="submit" name="update" class="btn btn-primary me-2">
                <i class="bi bi-check-circle me-1"></i> Actualizar
              </button>
              <a href="index.php" class="btn btn-outline-danger">
                <i class="bi bi-x-circle me-1"></i> Cancelar
              </a>
            </div>
          </form>

          <hr>

          <!-- ✅ Botón para regenerar token -->
          <form method="POST" class="mt-3">
            <button type="submit" name="generate_token" class="btn btn-secondary">
              <i class="bi bi-arrow-repeat me-1"></i> Generar nuevo token
            </button>
          </form>

        </div>
      </div>

    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
