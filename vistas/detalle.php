<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html"
    </script>
    ';
    session_destroy();
    die();
}
require_once "../models/conexion.php";
include "../models/ImpresionModel.php";
$con = connection();
$sql = "SELECT * FROM producto";
$query = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Detalle de Impresion</title>
     <!--     Fonts and icons     -->

     <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />


<!--   Core JS Files   -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../assets/js/plugins/bootstrap-switch.js"></script>

<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>

</head>
<body>
<?php
include "../includes/sidebar.php";
?>
<div class="main-panel">
<h3 class="card-title text-center align-middle">Agregar Detalle Impresion</h3>
    <div class="container mt-5">
        <form action="../controladores/ControladorDetalle.php" method="POST" class="row" name="form">
        <input type="hidden" name="action" value="insert" >
        <div class="col-md-6">
                <div class="form-group">
                    <label for="rol">Producto</label>
                    <select class="form-control" id="producto" name="producto" >
                        <option value="0">Seleccione</option>
                        <?php foreach ($query as $row): ?>
                            <option value="<?=$row["codigo_producto"]?>"><?=$row["nombre_p"]?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tamanio">Tamaño</label>
                    <input type="text" class="form-control" id="tamanio" name="tamanio" required">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="grosor">Grosor</label>
                    <input type="text" class="form-control" id="grosor" name="grosor" required">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="detalles">Detalles</label>
                    <input type="text" class="form-control" id="detalles" name="detalles" required>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Agregar Detalle de Impresion</button>
            </div>
        </form>
    </div>
</div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->

    <script>
        function formato(mascara, documento) {
            var i = documento.value.length;
            var salida = mascara.substring(0, 1);
            var texto = mascara.substring(i)

            if (texto.substring(0, 1) != salida) {
                documento.value += texto.substring(0, 1);
            }
        }
        function Solo_Texto(e) {
    var code;
    if (!e) var e = window.event;
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    var character = String.fromCharCode(code);
    var AllowRegex  = /^[\ba-zA-Z\s-]$/;
    if (AllowRegex.test(character)) return true;
    return false;
}
function formatoDUI(input) {
            var dui = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
            if (dui.length > 0) {
                dui = dui.substring(0, 8) + '-' + dui.substring(8, 9); // Agregar guión en la posición adecuada
            }
            input.value = dui; // Actualizar el valor del campo
        }
    </script>
</body>
</html>
