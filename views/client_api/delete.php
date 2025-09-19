<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/ClientApi.php';

$clientApi = new ClientApi($pdo);

$id = $_GET['id'] ?? null;
if ($id) {
    $clientApi->delete($id);
}
header("Location: index.php");
exit;
