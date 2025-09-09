<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../models/Departamento.php';

$departamentoModel = new Departamento();

$errors = [];
$success = null;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');

    if (empty($nombre)) {
        $errors[] = "El nombre del departamento es obligatorio.";
    }

    if (empty($errors)) {
        if ($departamentoModel->create($nombre)) {
            $success = "Departamento creado correctamente.";
            // Redirigir al listar
            header("Location: listar.php");
            exit;
        } else {
            $errors[] = "Error al guardar el departamento.";
        }
    }
}

$pageTitle = "Nuevo Departamento";
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
        <h2 class="fw-bold text-primary">➕ Nuevo Departamento</h2>
        <a href="listar.php" class="btn btn-secondary btn-sm">
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
              <label for="nombre" class="form-label fw-bold">Nombre del departamento</label>
              <input type="text" class="form-control" id="nombre" name="nombre" 
                     value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
            </div>
            <button type="submit" class="btn btn-success">
              <i class="bi bi-check-circle"></i> Guardar
            </button>
            <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>
          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
