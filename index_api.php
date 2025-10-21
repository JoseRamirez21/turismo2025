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
    <style>
        body { background: linear-gradient(135deg, #e0f7fa, #f1f8e9); font-family: 'Poppins', sans-serif; }
        .card { border-radius: 20px; transition: all 0.3s ease; }
        .card:hover { transform: scale(1.01); }
        #resultados { margin-top: 40px; }
        table { border-radius: 12px; overflow: hidden; }
        thead { background-color: #007bff; color: white; }
    </style>
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
                        <input type="text" id="token" name="token" class="form-control"
                               value="3d9745d326c616598a440eca7cd5e6e5-1" required>
                    </div>
                    <div class="col-md-4">
                        <label for="url_api" class="form-label fw-semibold">URL de la API</label>
                        <input type="text" id="url_api" name="url_api" class="form-control" 
                               value="<?php echo BASE_URL; ?>/api/buscar_api.php" required>
                    </div>
                    <div class="col-md-4">
                        <label for="dato" class="form-label fw-semibold">Término de búsqueda</label>
                        <input type="text" id="dato" name="dato" class="form-control" 
                               placeholder="Ejemplo: Cusco, selva, playa..." required>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">🔍 Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    <div id="resultados"></div>
</div>

<!-- Script corregido -->
<script src="<?php echo BASE_URL; ?>/views/buscar/script.js"></script>
</body>
</html>
