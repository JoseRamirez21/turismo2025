<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../models/Provincia.php';
require_once __DIR__ . '/../../../models/Departamento.php';

$provinciaModel = new Provincia();
$departamentoModel = new Departamento();

$departamentos = $departamentoModel->getAll();

$errors = [];
$success = null;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $id_departamento = intval($_POST['id_departamento'] ?? 0);

    if (empty($nombre)) {
        $errors[] = "El nombre de la provincia es obligatorio.";
    }
    if ($id_departamento <= 0) {
        $errors[] = "Debe seleccionar un departamento.";
    }

    if (empty($errors)) {
        if ($provinciaModel->create($nombre, $id_departamento)) {
            header("Location: listar.php");
            exit;
        } else {
            $errors[] = "Error al guardar la provincia.";
        }
    }
}

$pageTitle = "Nueva Provincia";
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
        <h2 class="fw-bold text-success">➕ Nueva Provincia</h2>
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

      <!-- Formulario -->
      <div class="card shadow-sm">
        <div class="card-body">
          <form method="POST">
            <div class="mb-3">
              <label for="nombre" class="form-label fw-bold">Nombre de la provincia</label>
              <input type="text" class="form-control" id="nombre" name="nombre" 
                     value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
              <label for="id_departamento" class="form-label fw-bold">Departamento</label>
              <select id="id_departamento" name="id_departamento" class="form-select" required>
                <option value="">-- Selecciona un departamento --</option>
                <?php foreach ($departamentos as $d): ?>
                  <option value="<?= $d['id_departamento'] ?>" 
                    <?= (($_POST['id_departamento'] ?? '') == $d['id_departamento']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
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
