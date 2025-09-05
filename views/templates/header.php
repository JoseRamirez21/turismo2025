<?php
// $pageTitle opcional
require_once __DIR__ . '/../../config/config.php';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : '' ?><?= APP_NAME ?></title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">

  <!-- Favicon -->
  <link rel="icon" href="<?= asset('assets/img/logo.png') ?>">

  <meta name="theme-color" content="#0d6efd">
  <meta name="description" content="Portal turístico profesional del Perú: departamentos, provincias, distritos y lugares turísticos.">
</head>
<body class="bg-light">
<script>
  window.APP = {
    BASE_URL: '<?= rtrim(BASE_URL, "/") ?>',
    API_BASE_URL: '<?= rtrim(API_BASE_URL, "/") ?>'
  };
</script>
