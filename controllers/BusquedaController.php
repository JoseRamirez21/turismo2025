<?php
require_once __DIR__ . '/../models/TokenModel.php';
require_once __DIR__ . '/../models/BusquedaModel.php';

class BusquedaController {
    private $tokenModel;
    private $busquedaModel;

    public function __construct() {
        $this->tokenModel = new TokenModel();
        $this->busquedaModel = new BusquedaModel();
    }

    /**
     * Procesa la búsqueda validando el token
     * @param string $token Token de acceso
     * @param string $dato Término de búsqueda
     * @return array Respuesta con estado, mensaje y datos
     */
    public function procesarBusqueda(string $token, string $dato): array {
        // 1️⃣ Validar token
        if (!$this->tokenModel->validarToken($token)) {
            return [
                'status' => 'error',
                'message' => '❌ Token inválido o inactivo.'
            ];
        }

        // 2️⃣ Validar término de búsqueda
        if (empty($dato)) {
            return [
                'status' => 'warning',
                'message' => '⚠️ Ingrese un término para buscar.'
            ];
        }

        // 3️⃣ Buscar en todas las tablas
        $resultados = $this->busquedaModel->buscarTodo($dato);

        // 4️⃣ Retornar resultados
        if (!empty($resultados)) {
            return [
                'status' => 'success',
                'message' => '✅ Resultados encontrados.',
                'data' => $resultados
            ];
        } else {
            return [
                'status' => 'info',
                'message' => '⚠️ No se encontraron resultados.'
            ];
        }
    }
}
