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
        body { 
            background: linear-gradient(135deg, #e0f7fa, #f1f8e9); 
            font-family: 'Poppins', sans-serif; 
        }
        .card-lugar {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .card-lugar:hover {
            transform: translateY(-5px);
        }
        #resultados {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold text-primary">🌎 Buscador Turístico</h3>
            <form id="formBusqueda">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <label for="token" class="form-label fw-semibold">Token de Acceso</label>
                        <input type="text" id="token" name="token" class="form-control"
                               value="3d9745d326c616598a440eca7cd5e6e5-1" required>
                    </div>
                    <input type="hidden" id="url_api" value="<?php echo BASE_URL; ?>/api/buscar_api.php">
                    <div class="col-md-6">
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
    <div id="resultados" class="row"></div>
</div>

<script src="<?php echo BASE_URL; ?>/views/buscar/script.js"></script>
</body>
</html>
