<?php
// Header exclusivo para admin
require_once __DIR__ . '/../../../config/config.php';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : '' ?><?= APP_NAME ?> - Admin</title>
  <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
  <link rel="icon" href="<?= asset('assets/img/logo.png') ?>">
  <meta name="theme-color" content="#182848">
</head>
<body>
