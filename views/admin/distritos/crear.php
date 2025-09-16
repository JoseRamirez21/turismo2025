<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/DistritoController.php';
require_once __DIR__ . '/../../../models/Departamento.php';
require_once __DIR__ . '/../../../models/Provincia.php';

$controller = new DistritoController();
$departamentoModel = new Departamento();
$provinciaModel = new Provincia();

$departamentos = $departamentoModel->getAll();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_provincia = $_POST['id_provincia'] ?? null;
    $nombre = trim($_POST['nombre'] ?? '');

    if (!$id_provincia) $errors[] = "Debe seleccionar una provincia.";
    if (empty($nombre)) $errors[] = "El nombre del distrito es obligatorio.";

    if (empty($errors)) {
        if ($controller->store(['id_provincia' => $id_provincia, 'nombre' => $nombre])) {
            header("Location: listar.php");
            exit;
        } else {
            $errors[] = "Error al guardar el distrito.";
        }
    }
}

$pageTitle = "Nuevo Distrito";
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
        <h2 class="fw-bold text-primary">➕ Nuevo Distrito</h2>
        <a href="listar.php" class="btn btn-warning btn-sm">
          <i class="bi bi-arrow-left"></i> Volver
        </a>
      </div>

      <!-- Mensajes de error -->
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

            <!-- Departamento -->
            <div class="mb-3">
              <label class="form-label fw-bold">Departamento</label>
              <select id="departamento" class="form-select">
                <option value="">Seleccione un departamento</option>
                <?php foreach ($departamentos as $dep): ?>
                  <option value="<?= $dep['id_departamento'] ?>">
                    <?= htmlspecialchars($dep['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Provincia -->
            <div class="mb-3">
              <label class="form-label fw-bold">Provincia</label>
              <select name="id_provincia" id="provincia" class="form-select" required>
                <option value="">Seleccione una provincia</option>
              </select>
            </div>

            <!-- Nombre Distrito -->
            <div class="mb-3">
              <label for="nombre" class="form-label fw-bold">Nombre del distrito</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
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

<script>
// Cargar provincias dinámicamente según departamento
document.getElementById('departamento').addEventListener('change', function() {
  let departamentoId = this.value;
  let provinciaSelect = document.getElementById('provincia');
  provinciaSelect.innerHTML = '<option value="">Cargando...</option>';

  if (departamentoId) {
    fetch('../../../controllers/AjaxController.php?action=provincias&id_departamento=' + departamentoId)
      .then(res => res.json())
      .then(data => {
        provinciaSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
        data.forEach(p => {
          provinciaSelect.innerHTML += `<option value="${p.id_provincia}">${p.nombre}</option>`;
        });
      });
  } else {
    provinciaSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
  }
});
</script>
