<?php
require_once __DIR__ . '/config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🌎 Buscador Turístico - API</title>
    <link href="<?php echo BASE_URL; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const BASE_URL = "<?php echo BASE_URL; ?>";
    </script>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold text-primary">🌎 Buscador Turístico - API</h3>
            <form id="formBusqueda">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="token" class="form-label fw-semibold">Token de Acceso</label>
                        <input type="text" id="token" name="token" class="form-control" placeholder="Ingrese su token..." required>
                    </div>
                    <div class="col-md-4">
                        <label for="url_api" class="form-label fw-semibold">URL de la API</label>
                        <input type="text" id="url_api" name="url_api" class="form-control" value="<?php echo BASE_URL; ?>/api/buscar_api.php" required>
                    </div>
                    <div class="col-md-4">
                        <label for="dato" class="form-label fw-semibold">Término de búsqueda</label>
                        <input type="text" id="dato" name="dato" class="form-control" placeholder="Ejemplo: Cusco, selva, playa..." required>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">🔍 Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    <div class="mt-5" id="resultados"></div>
</div>

<script src="<?php echo BASE_URL; ?>/views/buscar/script.js"></script>
</body>
</html>
