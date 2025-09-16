<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/AdminController.php';

$adminController = new AdminController();
$errors = [];
$success = null;

// Función para validar contraseña segura
function esPasswordSegura(string $password): bool {
    return strlen($password) >= 8 && preg_match('/[a-zA-Z]/', $password) && preg_match('/[0-9]/', $password);
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nombre)) $errors[] = "El nombre es obligatorio.";
    if (empty($email)) $errors[] = "El email es obligatorio.";
    if (empty($password)) {
        $errors[] = "La contraseña es obligatoria.";
    } elseif (!esPasswordSegura($password)) {
        $errors[] = "Contraseña débil. Debe ser segura.";
    }

    if (empty($errors)) {
        if ($adminController->store($nombre, $email, $password)) {
            header("Location: listar.php?created=1");
            exit;
        } else {
            $errors[] = "Error al guardar el administrador.";
        }
    }
}

$pageTitle = "Nuevo Administrador";
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
        <h2 class="fw-bold text-primary">➕ Nuevo Administrador</h2>
        <a href="listar.php" class="btn btn-warning btn-sm">
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
              <label for="nombre" class="form-label fw-bold">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre"
                     value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-bold">Email</label>
              <input type="email" class="form-control" id="email" name="email"
                     value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label fw-bold">Contraseña</label>
              <input type="password" class="form-control" id="password" name="password" required>
              <small class="text-muted">La contraseña debe ser segura.</small>
            </div>

            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-circle"></i> Guardar
            </button>
            <a href="listar.php" class="btn btn-outline-danger">Cancelar</a>
          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
