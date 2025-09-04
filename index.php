<?php
$pageTitle = 'Inicio';
require __DIR__ . '/config/config.php';
require view_path('views/templates/header.php');
require view_path('views/templates/navbar.php');
require view_path('components/card-lugar.php');
?>

<section class="hero">
  <div class="hero-content text-white px-3">
    <h1 class="display-5 mb-3">Descubre el Perú auténtico</h1>
    <p class="lead mb-4">Explora departamentos, provincias y distritos con sus lugares turísticos más emblemáticos.</p>
    <a href="<?= BASE_URL ?>/views/departamentos/listar.php" class="btn btn-light btn-lg">Explorar por departamentos</a>
  </div>
</section>

<section class="container py-5">
  <h2 class="section-title mb-4 text-center">Lugares Turísticos Destacados</h2>
  <div class="row">
    <?php
   require_once view_path('components/card-lugar.php');



    // Simulación de datos (esto después saldrá de la BD/API)
    $lugares = [
      [
        "img" => asset("assets/img/lugares/machu-picchu.jpg"),
        "titulo" => "Machu Picchu",
        "subtitulo" => "Cusco · Histórico",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=1"
      ],
      [
        "img" => asset("assets/img/lugares/lineas-nazca.jpg"),
        "titulo" => "Líneas de Nazca",
        "subtitulo" => "Ica · Arqueológico",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=2"
      ],
      [
        "img" => asset("assets/img/lugares/laguna-69.jpg"),
        "titulo" => "Laguna 69",
        "subtitulo" => "Áncash · Natural",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=3"
      ],
      [
        "img" => asset("assets/img/lugares/canon-colca.jpg"),
        "titulo" => "Cañón del Colca",
        "subtitulo" => "Arequipa · Natural",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=4"
      ],
      [
        "img" => asset("assets/img/lugares/paracas.jpg"),
        "titulo" => "Reserva de Paracas",
        "subtitulo" => "Ica · Natural",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=5"
      ],
      [
        "img" => asset("assets/img/lugares/gocta.jpg"),
        "titulo" => "Catarata de Gocta",
        "subtitulo" => "Amazonas · Natural",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=6"
      ],
      [
        "img" => asset("assets/img/lugares/kuelap.jpg"),
        "titulo" => "Fortaleza de Kuélap",
        "subtitulo" => "Amazonas · Arqueológico",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=7"
      ],
      [
        "img" => asset("assets/img/lugares/titicaca.jpg"),
        "titulo" => "Lago Titicaca",
        "subtitulo" => "Puno · Natural",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=8"
      ],
      [
        "img" => asset("assets/img/lugares/huacachina.jpg"),
        "titulo" => "Oasis de Huacachina",
        "subtitulo" => "Ica · Natural",
        "link" => BASE_URL . "/views/lugares/detalle.php?id=9"
      ],
    ];

    foreach ($lugares as $lugar) {
      card_lugar($lugar);
    }
    ?>
  </div>
</section>


<?php require view_path('views/templates/footer.php'); ?>
