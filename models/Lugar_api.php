<?php

class Lugar_api {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarLugares($dato) {
        // Sanitizar el dato de búsqueda
        $dato = "%" . $dato . "%";  

    $sql = "SELECT l.id_lugar, l.nombre, l.tipo, d.nombre AS distrito, p.nombre AS provincia, dep.nombre AS departamento
        FROM lugares_turisticos l
        JOIN distritos d ON l.id_distrito = d.id_distrito
        JOIN provincias p ON d.id_provincia = p.id_provincia
        JOIN departamentos dep ON p.id_departamento = dep.id_departamento
        WHERE l.nombre LIKE :datoNombre
        OR l.tipo LIKE :datoTipo
        OR d.nombre LIKE :datoDistrito
        OR p.nombre LIKE :datoProvincia
        OR dep.nombre LIKE :datoDepartamento";


        try {
            // Prepara la consulta
            $stmt = $this->pdo->prepare($sql);
          $stmt->execute([
    'datoNombre' => $dato,
    'datoTipo' => $dato,
    'datoDistrito' => $dato,
    'datoProvincia' => $dato,
    'datoDepartamento' => $dato
]);


            // Retorna los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Captura y muestra el error si ocurre uno
            echo "Error en la consulta: " . $e->getMessage();
            return [];
        }
    }
}

?>
