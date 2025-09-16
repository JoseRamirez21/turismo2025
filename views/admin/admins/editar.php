<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../models/Admin.php';

$adminModel = new Admin();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: listar.php");
    exit;
}

$admin = $adminModel->getById((int)$id);
if (!$admin) {
    header("Location: listar.php");
    exit;
}

$errors = [];
$success = null;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nombre)) $errors[] = "El nombre es obligatorio.";
    if (empty($email)) $errors[] = "El correo electrónico es obligatorio.";

    if (empty($errors)) {
        if ($adminModel->update((int)$id, $nombre, $email, $password ?: null)) {
            $success = "Administrador actualizado correctamente.";
            header("Location: listar.php?updated=1");
            exit;
        } else {
            $errors[] = "Error al actualizar el administrador.";
        }
    }
}

$pageTitle = "Editar Administrador";
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
      <!-- Encabezado -->
      <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-primary">✏️ Editar Administrador</h2>
        <a href="listar.php" class="btn btn-warning btn-sm">
          <i class="bi bi-arrow-left"></i> Volver
        </a>
      </div>

      <!-- Mensajes -->
      <?php if ($errors): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <!-- Formulario -->
      <div class="card shadow-sm">
        <div class="card-body">
          <form method="POST">
            <div class="mb-3">
              <label for="nombre" class="form-label fw-bold">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" 
                     value="<?= htmlspecialchars($_POST['nombre'] ?? $admin['nombre']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-bold">Correo electrónico</label>
              <input type="email" class="form-control" id="email" name="email" 
                     value="<?= htmlspecialchars($_POST['email'] ?? $admin['email']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label fw-bold">Contraseña (opcional)</label>
              <input type="password" class="form-control" id="password" name="password"
                     placeholder="Dejar en blanco si no deseas cambiarla">
            </div>

            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-circle"></i> Actualizar
            </button>
            <a href="listar.php" class="btn btn-outline-danger">Cancelar</a>
          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
