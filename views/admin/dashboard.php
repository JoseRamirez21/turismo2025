<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Lugar.php';

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) session_start();

// Validar que el admin haya iniciado sesión
if (!isset($_SESSION['admin_id'])) {
    header("Location: " . BASE_URL . "/views/admin/login.php");
    exit;
}

// Instanciamos modelo de lugares
$lugarModel = new Lugar();
$lugares = $lugarModel->getAll(); // Necesitamos agregar un método getAll() en Lugar

// Header + Navbar
require view_path('views/templates/header.php');
require view_path('views/templates/navbar.php');
?>

<div class="container py-5">
    <h1 class="h3 mb-4">Panel de Administración</h1>

    <a href="<?= BASE_URL ?>/views/admin/lugares/agregar.php" class="btn btn-success mb-3">+ Agregar lugar</a>

    <table class="table table-striped table-hover shadow-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Distrito</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lugares as $lugar): ?>
                <tr>
                    <td><?= htmlspecialchars($lugar['id_lugar']) ?></td>
                    <td><?= htmlspecialchars($lugar['nombre']) ?></td>
                    <td><?= htmlspecialchars($lugar['tipo']) ?></td>
                    <td><?= htmlspecialchars($lugar['id_distrito']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/views/admin/lugares/editar.php?id=<?= $lugar['id_lugar'] ?>" class="btn btn-sm btn-primary">Editar</a>
                        <a href="<?= BASE_URL ?>/views/admin/lugares/eliminar.php?id=<?= $lugar['id_lugar'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este lugar?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require view_path('views/templates/footer.php');
?>
