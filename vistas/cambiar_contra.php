<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <title>Recuperacion de Contraseña</title>
  </head>
  <body>
    <form class="form-02-main" action="../includes/cambiar_pass.php" method="POST">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="_lk_de">
              <div class="form-03-main">
                <div class="">
                  <img src="../images/logo.png">
                </div>
                <input type="hidden" name="id" type="text" value="<?php echo $_GET['id']; ?>">
                <div class="form-group">
                  <input type="password" name="newpass" class="form-control _ge_de_ol" type="text" placeholder="Nueva Contraseña" required="" aria-required="true">
                </div>
                <div class="form-group">
                  <div>
                    <button class="_btn_04">Cambiar Contraseña</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </body>
</html>