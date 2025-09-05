<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Admin.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_id'])) {
   header('Location: dashboard.php');
exit;

}

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $clave = trim($_POST['password'] ?? '');

    if ($email && $clave) {
        $adminModel = new Admin();
        $admin = $adminModel->login($email, $clave);

        if ($admin) {
            $_SESSION['admin_id'] = $admin['id_admin'];
            $_SESSION['admin_nombre'] = $admin['nombre'];
            header('Location: dashboard.php');
exit;

        } else {
            $mensaje = 'Usuario o contraseña incorrectos';
        }
    } else {
        $mensaje = 'Debe completar todos los campos';
    }
}
?>

<?php require view_path('views/templates/header.php'); ?>
<?php require view_path('views/templates/navbar.php'); ?>

<!-- ===== LOGIN MODERNO ===== -->
<div class="container py-5" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 400px; width: 100%; background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%); color: #fff;">
        <div class="text-center mb-4">
            <img src="<?= asset('assets/img/logo.png') ?>" alt="Logo" class="mb-2" style="width: 80px;">
            <h3 class="fw-bold">Panel de Administrador</h3>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" id="email" name="email" class="form-control rounded-pill" placeholder="ejemplo@turismo.com" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control rounded-pill" placeholder="********" required>
            </div>
            <button type="submit" class="btn btn-warning w-100 rounded-pill fw-bold">Iniciar sesión</button>
        </form>

        <div class="text-center mt-3">
            <small>Solo administradores autorizados</small>
        </div>
    </div>
</div>

<?php require view_path('views/templates/footer.php'); ?>
