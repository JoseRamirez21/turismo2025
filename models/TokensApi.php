<?php
class TokensApi {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 📌 Crear nuevo token
   public function create($data)
{
    $sql = "INSERT INTO tokens_api (id_client_api, token, fecha_registro, estado) 
            VALUES (:id_client_api, :token, NOW(), :estado)";
    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ':id_client_api' => $data['id_client_api'],
        ':token'         => $data['token'],
        ':estado'        => $data['estado'] ?? 1   // 👈 Valor por defecto 1
    ]);

    return $this->pdo->lastInsertId();
}


    // 📌 Obtener todos los registros
    public function getAll() {
        $sql = "SELECT * FROM tokens_api ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 📌 Obtener un registro por ID
// Obtener token por ID
public function getById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM tokens_api WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // 📌 Actualizar registro
    public function update($id, $data)
{
    $stmt = $this->pdo->prepare("
        UPDATE tokens_api 
        SET id_client_api = :id_client_api, token = :token, estado = :estado 
        WHERE id = :id
    ");

    return $stmt->execute([
        ':id_client_api' => $data['id_client_api'],
        ':token'         => $data['token'],
        ':estado'        => $data['estado'],
        ':id'           => $id
    ]);
}


    // 📌 Eliminar registro
    public function delete($id) {
        $sql = "DELETE FROM tokens_api WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function find($id)
{
    $stmt = $this->pdo->prepare("SELECT * FROM tokens_api WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


}
