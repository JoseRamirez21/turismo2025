<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/TokensApiController.php';
require_once __DIR__ . '/../../controllers/ClientApiController.php';

// Verificar sesión de admin
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/views/admin/login.php');
    exit;
}

// Instanciamos controladores
$tokensController = new TokensApiController($pdo);
$clientController = new ClientApiController($pdo);
$clients = $clientController->index();

$errors = [];

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client_api = trim($_POST['id_client_api'] ?? '');
    $estado        = $_POST['estado'] ?? 1;

    // Validación
    if (empty($id_client_api)) {
        $errors[] = "Debe seleccionar un cliente.";
    }

    if (empty($errors)) {
        // Generar token automáticamente
        $randomToken = bin2hex(random_bytes(16)); // 32 caracteres aleatorios
        $tokenGenerado = $randomToken . '-' . $id_client_api; // token + ID cliente

        $data = [
            'id_client_api' => $id_client_api,
            'token'         => $tokenGenerado,
            'estado'        => $estado
        ];

        if ($tokensController->create($data)) {
            header("Location: index.php?created=1");
            exit;
        } else {
            $errors[] = "No se pudo registrar el token. Inténtalo nuevamente.";
        }
    }
}

$pageTitle = "Nuevo Token";
require view_path('views/admin/templates/header.php');
require view_path('views/admin/templates/topbar.php');
?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php require view_path('views/admin/templates/sidebar.php'); ?>
    </div>

    <!-- Contenido principal -->
    <main class="col-md-9 col-lg-10 px-md-4 py-4">
      
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary">
          <i class="bi bi-plus-circle-fill me-2"></i> Nuevo Token API
        </h2>
        <a href="index.php" class="btn btn-warning btn-sm shadow-sm">
          <i class="bi bi-arrow-left"></i> Volver
        </a>
      </div>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
          <form method="POST">
            
            <!-- Cliente -->
            <div class="mb-3">
              <label for="id_client_api" class="form-label fw-semibold">
                <i class="bi bi-person-badge me-1"></i> Cliente
              </label>
              <select name="id_client_api" id="id_client_api" class="form-select" required>
                <option value="">-- Seleccionar cliente --</option>
                <?php foreach ($clients as $client): ?>
                  <option value="<?= $client['id'] ?>" 
                    <?= (($_POST['id_client_api'] ?? '') == $client['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($client['nombre'] . ' ' . $client['apellido']) ?> (DNI: <?= htmlspecialchars($client['dni']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Estado -->
            <div class="mb-3">
              <label for="estado" class="form-label fw-semibold">
                <i class="bi bi-toggle-on me-1"></i> Estado
              </label>
              <select name="estado" id="estado" class="form-select">
                <option value="1" <?= (($_POST['estado'] ?? 1) == 1) ? 'selected' : '' ?>>Activo</option>
                <option value="0" <?= (($_POST['estado'] ?? 1) == 0) ? 'selected' : '' ?>>Inactivo</option>
              </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary shadow-sm me-2">
                <i class="bi bi-save"></i> Guardar
              </button>
              <a href="index.php" class="btn btn-outline-danger shadow-sm">
                <i class="bi bi-x-circle"></i> Cancelar
              </a>
            </div>

          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
