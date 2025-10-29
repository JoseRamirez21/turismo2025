<?php
// controllers/BuscarApiController.php

class BuscarApiController {
    private $lugarApiModel;

    public function __construct($pdo) {
        // Inicializar el modelo de Lugar con la conexión PDO
        $this->lugarApiModel = new Lugar_api($pdo);
    }

   public function buscar() {
    // Obtener los datos del cuerpo de la solicitud (JSON)
    $input = json_decode(file_get_contents('php://input'), true);
    $token = isset($input['token']) ? trim($input['token']) : '';
    $dato = isset($input['dato']) ? trim($input['dato']) : '';

    // Validar
    if (empty($token)) {
        echo json_encode(['status' => 'error', 'message' => '❌ Token no proporcionado.']);
        exit;
    }

    if (empty($dato)) {
        echo json_encode(['status' => 'warning', 'message' => '⚠️ Ingrese un término de búsqueda.']);
        exit;
    }

    try {
        // Buscar los lugares turísticos usando el modelo
        $lugares = $this->lugarApiModel->buscarLugares($dato);

        // Devolver los resultados en formato JSON
        if (!empty($lugares)) {
            echo json_encode([
                'status' => 'success',
                'message' => '✅ Resultados encontrados.',
                'data' => $lugares
            ]);
        } else {
            echo json_encode([
                'status' => 'info',
                'message' => '⚠️ No se encontraron resultados.',
                'data' => []
            ]);
        }
    } catch (Exception $e) {
        // En caso de un error, devolver un mensaje de error
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Error en la consulta: ' . $e->getMessage(),
            'data' => []
        ]);
    }
}

    
}

?>
