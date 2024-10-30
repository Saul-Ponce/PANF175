<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html";
    </script>
    ';
    session_destroy();
    die();
}
require_once("../models/conexion.php");
include("../models/ClienteJuridicoModel.php");
include("../models/ClasificacionModel.php");

// Obtener las clasificaciones existentes para el select
$clasificaciones = ClasificacionModel::listar();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente Jurídico</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />

    <!-- Core JS Files -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/bootstrap-switch.js"></script>
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0" type="text/javascript"></script>
</head>
<body>
<?php include("../includes/sidebar.php"); ?>
<div class="main-panel">
    <h3 class="card-title text-center align-middle">Agregar Cliente Jurídico</h3>
    <div class="container mt-5">
        <form action="../controladores/ControladorClienteJuridico.php" method="POST" class="row" name="form">
            <input type="hidden" name="action" value="insert">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre de la Empresa</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" maxlength="15" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="representante_legal">Representante Legal</label>
                    <input type="text" class="form-control" id="representante_legal" name="representante_legal" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="aval">Aval</label>
                    <input type="text" class="form-control" id="aval" name="aval">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="clasificacion_id">Clasificación</label>
                    <select class="form-control" id="clasificacion_id" name="clasificacion_id" required>
                        <option value="" disabled selected>Seleccione una clasificación</option>
                        <?php while ($clasificacion = mysqli_fetch_assoc($clasificaciones)) : ?>
                            <option value="<?php echo $clasificacion['id']; ?>">
                                <?php echo $clasificacion['nombre']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Agregar Cliente Jurídico</button>
            </div>
        </form>
    </div>
</div>

<script>
    function Solo_Texto(e) {
        var code;
        if (!e) var e = window.event;
        if (e.keyCode) code = e.keyCode;
        else if (e.which) code = e.which;
        var character = String.fromCharCode(code);
        var AllowRegex  = /^[\ba-zA-Z\s-]$/;
        if (AllowRegex.test(character)) return true;     
        return false;
    }
</script>
</body>
</html>
