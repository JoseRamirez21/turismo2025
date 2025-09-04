<?php
require_once __DIR__ . "/config/config.php";

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT COUNT(*) AS total FROM departamentos");
$row = $stmt->fetch();

echo "✅ Conexión OK. Hay " . $row['total'] . " departamentos en la BD.";
