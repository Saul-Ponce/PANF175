<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Pagina en mantemiento</title>
  <?php include '../layouts/headerStyles.php'; ?>
</head>

<body class=" border-top-wide border-primary d-flex flex-column">
  <script src="./../public/assets/js/demo-theme.min.js?1692870487"></script>
  <div class="page page-center">
    <div class="container-tight py-4">
      <div class="empty">
        <div class="empty-img"><img src="../public/assets/img/undraw_quitting_time_dm8t.svg" height="128" alt="">
        </div>
        <p class="empty-title">Pagina en construccion</p>
        <p class="empty-subtitle text-secondary">
          La pagina a la que intentas acceder no esta disponible temporalmente, estara activa cuando se haya
          terminado
          de crear
        </p>
        <div class="empty-action">
          <a href="./home.php" class="btn btn-primary">
            <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
              stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M5 12l14 0" />
              <path d="M5 12l6 6" />
              <path d="M5 12l6 -6" />
            </svg>
            Volver al inicio
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php include '../layouts/footerScript.php'; ?>
</body>

</html>