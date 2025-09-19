<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/ClientApi.php';

$clientApiModel = new ClientApi($pdo);

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: index.php");
    exit;
}

$cliente = $clientApiModel->getById((int)$id);
if (!$cliente) {
    header("Location: index.php");
    exit;
}

$errors = [];
$success = null;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni      = trim($_POST['dni'] ?? '');
    $nombre   = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo   = trim($_POST['correo'] ?? '');
    $estado   = $_POST['estado'] ?? 1;

    if (empty($dni) || empty($nombre) || empty($apellido)) {
        $errors[] = "DNI, nombre y apellido son obligatorios.";
    }

    if (empty($errors)) {
        if ($clientApiModel->update((int)$id, [
            'dni'      => $dni,
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'correo'   => $correo,
            'estado'   => $estado
        ])) {
            $success = "Cliente actualizado correctamente.";
            header("Location: index.php?updated=1");
            exit;
        } else {
            $errors[] = "Error al actualizar el cliente.";
        }
    }
}

$pageTitle = "Editar Cliente";
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
        <h2 class="fw-bold text-primary">✏️ Editar Cliente</h2>
        <a href="index.php" class="btn btn-warning btn-sm">
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
              <label for="dni" class="form-label fw-bold">DNI</label>
              <input type="text" class="form-control" id="dni" name="dni"
                     value="<?= htmlspecialchars($_POST['dni'] ?? $cliente['dni']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="nombre" class="form-label fw-bold">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre"
                     value="<?= htmlspecialchars($_POST['nombre'] ?? $cliente['nombre']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="apellido" class="form-label fw-bold">Apellido</label>
              <input type="text" class="form-control" id="apellido" name="apellido"
                     value="<?= htmlspecialchars($_POST['apellido'] ?? $cliente['apellido']) ?>" required>
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label fw-bold">Teléfono</label>
              <input type="text" class="form-control" id="telefono" name="telefono"
                     value="<?= htmlspecialchars($_POST['telefono'] ?? $cliente['telefono']) ?>">
            </div>

            <div class="mb-3">
              <label for="correo" class="form-label fw-bold">Correo</label>
              <input type="email" class="form-control" id="correo" name="correo"
                     value="<?= htmlspecialchars($_POST['correo'] ?? $cliente['correo']) ?>">
            </div>

            <div class="mb-3">
              <label for="estado" class="form-label fw-bold">Estado</label>
              <select class="form-select" id="estado" name="estado">
                <option value="1" <?= ($cliente['estado'] == 1) ? 'selected' : '' ?>>Activo</option>
                <option value="0" <?= ($cliente['estado'] == 0) ? 'selected' : '' ?>>Inactivo</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-circle"></i> Actualizar
            </button>
            <a href="index.php" class="btn btn-outline-danger">Cancelar</a>
          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>
