<?php
// models/Admin.php
require_once __DIR__ . '/../config/config.php';

class Admin {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // 🔹 Listar todos los administradores con búsqueda y límite
   public function getAll(string $search = '', int $limit = 20, int $offset = 0): array {
    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT id_admin, nombre, email, fecha_creacion
            FROM admins
            WHERE nombre LIKE :searchNombre OR email LIKE :searchEmail
            ORDER BY nombre ASC
            LIMIT $limit OFFSET $offset";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':searchNombre', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':searchEmail', "%$search%", PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    // 🔹 Contar admins (para paginación)
    public function count(string $search = ''): int {
        $sql = "SELECT COUNT(*) FROM admins WHERE nombre LIKE :search OR email LIKE :search";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    // 🔹 Obtener un admin por ID
    public function getById(int $id_admin): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE id_admin = ?");
        $stmt->execute([$id_admin]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // 🔹 Crear nuevo admin
    public function create(string $nombre, string $email, string $password): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO admins (nombre, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $email, $hash]);
    }

    // 🔹 Actualizar admin
    public function update(int $id_admin, string $nombre, string $email, ?string $password = null): bool {
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE admins SET nombre = ?, email = ?, password = ? WHERE id_admin = ?");
            return $stmt->execute([$nombre, $email, $hash, $id_admin]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE admins SET nombre = ?, email = ? WHERE id_admin = ?");
            return $stmt->execute([$nombre, $email, $id_admin]);
        }
    }

    // 🔹 Eliminar admin
    public function delete(int $id_admin): bool {
        $stmt = $this->pdo->prepare("DELETE FROM admins WHERE id_admin = ?");
        return $stmt->execute([$id_admin]);
    }

    // 🔹 Login
    public function login(string $email, string $clave): ?array {
        $stmt = $this->pdo->prepare("SELECT id_admin, nombre, email, password FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$admin) return null;

        if (!password_verify($clave, $admin['password'])) return null;

        return $admin;
    }
}
