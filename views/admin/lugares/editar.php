<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../controllers/LugarController.php';
require_once __DIR__ . '/../../../models/Departamento.php';
require_once __DIR__ . '/../../../models/Provincia.php';
require_once __DIR__ . '/../../../models/Distrito.php';

$controller = new LugarController();
$departamentoModel = new Departamento();
$provinciaModel = new Provincia();
$distritoModel = new Distrito();

$departamentos = $departamentoModel->getAll();
$errors = [];

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: listar.php");
    exit;
}

$lugar = $controller->show($_GET['id']);

if (!$lugar) {
    header("Location: listar.php");
    exit;
}

// Obtener distrito, provincia y departamento del lugar
$distrito = $distritoModel->getById($lugar['id_distrito']);
$provincia = $provinciaModel->getById($distrito['id_provincia'] ?? 0);
$departamentoId = $provincia['id_departamento'] ?? 0;
$provinciaId = $provincia['id_provincia'] ?? 0;

// Cargar provincias del departamento
$provincias = $provinciaModel->getByDepartamento($departamentoId);

// Cargar distritos de la provincia
$distritos = $distritoModel->getByProvincia($provinciaId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'descripcion' => trim($_POST['descripcion'] ?? ''),
        'tipo' => trim($_POST['tipo'] ?? ''),
        'latitud' => trim($_POST['latitud'] ?? ''),
        'longitud' => trim($_POST['longitud'] ?? ''),
        'id_distrito' => $_POST['id_distrito'] ?? null
    ];

    if (!$data['id_distrito']) $errors[] = "Debe seleccionar un distrito.";
    if (empty($data['nombre'])) $errors[] = "El nombre del lugar es obligatorio.";

    if (empty($errors)) {
        if ($controller->update((int)$id, $data)) {
            header("Location: listar.php");
            exit;
        } else {
            $errors[] = "Error al actualizar el lugar turístico.";
        }
    }
}

$pageTitle = "Editar Lugar Turístico";
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
        <h2 class="fw-bold text-warning">✏️ Editar Lugar Turístico</h2>
        <a href="listar.php" class="btn btn-secondary btn-sm">
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

            <!-- Departamento -->
            <div class="mb-3">
              <label class="form-label fw-bold">Departamento</label>
              <select id="departamento" class="form-select">
                <option value="">Seleccione un departamento</option>
                <?php foreach ($departamentos as $dep): ?>
                  <option value="<?= $dep['id_departamento'] ?>" <?= ($dep['id_departamento'] == $departamentoId) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dep['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Provincia -->
            <div class="mb-3">
              <label class="form-label fw-bold">Provincia</label>
              <select id="provincia" class="form-select">
                <option value="">Seleccione una provincia</option>
                <?php foreach ($provincias as $prov): ?>
                  <option value="<?= $prov['id_provincia'] ?>" <?= ($prov['id_provincia'] == $provinciaId) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($prov['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Distrito -->
            <div class="mb-3">
              <label class="form-label fw-bold">Distrito</label>
              <select name="id_distrito" id="distrito" class="form-select" required>
                <option value="">Seleccione un distrito</option>
                <?php foreach ($distritos as $dist): ?>
                  <option value="<?= $dist['id_distrito'] ?>" <?= ($dist['id_distrito'] == $lugar['id_distrito']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dist['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Nombre del Lugar -->
            <div class="mb-3">
              <label class="form-label fw-bold">Nombre del Lugar</label>
              <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($lugar['nombre']) ?>" required>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
              <label class="form-label fw-bold">Descripción</label>
              <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($lugar['descripcion']) ?></textarea>
            </div>

            <!-- Tipo -->
            <div class="mb-3">
              <label class="form-label fw-bold">Tipo</label>
              <input type="text" name="tipo" class="form-control" value="<?= htmlspecialchars($lugar['tipo']) ?>">
            </div>

            <!-- Latitud -->
            <div class="mb-3">
              <label class="form-label fw-bold">Latitud</label>
              <input type="text" name="latitud" class="form-control" value="<?= htmlspecialchars($lugar['latitud']) ?>">
            </div>

            <!-- Longitud -->
            <div class="mb-3">
              <label class="form-label fw-bold">Longitud</label>
              <input type="text" name="longitud" class="form-control" value="<?= htmlspecialchars($lugar['longitud']) ?>">
            </div>

            <button type="submit" class="btn btn-success">
              <i class="bi bi-check-circle"></i> Actualizar
            </button>
            <a href="listar.php" class="btn btn-outline-secondary">Cancelar</a>

          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<?php require view_path('views/admin/templates/footer.php'); ?>

<script>
// Cargar provincias según departamento
document.getElementById('departamento').addEventListener('change', function() {
  let depId = this.value;
  let provSelect = document.getElementById('provincia');
  let distSelect = document.getElementById('distrito');

  provSelect.innerHTML = '<option value="">Cargando...</option>';
  distSelect.innerHTML = '<option value="">Seleccione un distrito</option>';

  if (depId) {
    fetch('../../../controllers/AjaxController.php?action=provincias&id_departamento=' + depId)
      .then(res => res.json())
      .then(data => {
        provSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
        data.forEach(p => {
          provSelect.innerHTML += `<option value="${p.id_provincia}">${p.nombre}</option>`;
        });
      });
  } else {
    provSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
  }
});

// Cargar distritos según provincia
document.getElementById('provincia').addEventListener('change', function() {
  let provId = this.value;
  let distSelect = document.getElementById('distrito');
  distSelect.innerHTML = '<option value="">Cargando...</option>';

  if (provId) {
    fetch('../../../controllers/AjaxController.php?action=distritos&id_provincia=' + provId)
      .then(res => res.json())
      .then(data => {
        distSelect.innerHTML = '<option value="">Seleccione un distrito</option>';
        data.forEach(d => {
          distSelect.innerHTML += `<option value="${d.id_distrito}">${d.nombre}</option>`;
        });
      });
  } else {
    distSelect.innerHTML = '<option value="">Seleccione un distrito</option>';
  }
});
</script>
