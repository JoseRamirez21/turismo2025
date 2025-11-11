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

        .card { 
            border-radius: 20px; 
            transition: all 0.3s ease; 
        }

        .card:hover { 
            transform: scale(1.02); 
        }

        #resultados { 
            margin-top: 40px; 
            display: flex; 
            flex-wrap: wrap; 
            gap: 20px; 
            justify-content: center; 
        }

        .card-img-top { 
            height: 180px; 
            object-fit: cover; 
            border-radius: 20px 20px 0 0; 
        }

        .card-body { 
            text-align: center; 
        }

        /* Limitar ancho máximo de card para que no se estire */
        .card-wrapper {
            max-width: 300px;
            flex: 1 1 auto;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h3 class="text-center mb-4 fw-bold text-primary">🌎 Buscador Turístico - API</h3>
            <form id="formBusqueda">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <input type="hidden" id="token" name="token" class="form-control"
                               value="77790ffa98bfe3f332365ff43afdddf7-2" required>
                    </div>
                    <div class="col-md-6">
                        <label for="dato" class="form-label fw-semibold">Término de búsqueda</label>
                        <input type="text" id="dato" name="dato" class="form-control" 
                               placeholder="Ejemplo: Cusco, selva, playa..." required>
                    </div>
                </div>
                <input type="hidden" id="url_api" value="<?php echo BASE_URL; ?>/api/buscar_api.php">

                <div class="mt-3 text-center">
                    <button type="submit" class="btn btn-primary w-50 shadow-sm">🔍 Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    <div id="resultados"></div>
</div>

<script>var baseUrl = "<?php echo BASE_URL; ?>";</script>
<script src="<?php echo BASE_URL; ?>/views/buscar/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
