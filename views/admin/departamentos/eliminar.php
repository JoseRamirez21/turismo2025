<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../models/Departamento.php';

$departamentoModel = new Departamento();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    if ($departamentoModel->delete($id)) {
        header("Location: listar.php?deleted=1");
        exit;
    } else {
        header("Location: listar.php?error=1");
        exit;
    }
}
header("Location: listar.php");
exit;
