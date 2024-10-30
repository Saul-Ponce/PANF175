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
date_default_timezone_set('America/El_Salvador');
require_once "../models/conexion.php";
include "../models/EquipoModel.php";
$con = connection();
$sql = "SELECT * FROM cliente";
$query = mysqli_query($con, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Técnica</title>



 <!--     Fonts and icons     -->

 <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />


<!--   Core JS Files   -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../assets/js/plugins/bootstrap-switch.js"></script>

<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>

</head>
<body>

<?php include '../includes/sidebar.php';?>
<div class="main-panel">
    <div class="container mt-4">
        <form action="../controladores/ControladorEquipo.php" method="POST" class="row" name="form" id="equipo-form">
            <input type="hidden" name="action" value="insert">
            <div class="col-12 text-center">
                <h2>Ficha Técnica</h2>
            </div>
            <div class="col-md-6">
                <label for="fecha_r" class="form-label">Fecha de Recibido</label>
                <input type="date" class="form-control" id="fecha_r" name="fecha_r" value="<?=date('Y-m-d')?>" max="<?=date('Y-m-d')?>">
            </div>
            <div class="col-md-6">
                <label for="marca" class="form-label">Marca y modelo</label>
                <input type="text" class= "form-control" id="marca" name="marca" >
            </div>
            <div class="col-md-6">
                <label for="procesador" class="form-label">Procesador</label>
                <input type="text" class="form-control" id="procesador" name="procesador" >
            </div>
            <div class="col-md-6">
                <label for="ram" class="form-label">Memoria RAM</label>
                <input type="text" class="form-control" id="ram" name="ram" >
            </div>
            <div class="col-md-6">
                <label for="almacenamiento" class="form-label">Almacenamiento</label>
                <input type="text" class="form-control" id="almacenamiento" name="almacenamiento" >
            </div>
            <div class="col-12">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control" id="observaciones" rows="4" name="observaciones" ></textarea>
            </div>
            <div class="col-md-6">
                <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" min="<?=date('Y-m-d')?>">
            </div>
            <div class="col-md-6">
                <label for="dui_cliente" class="form-label">DUI de Cliente</label>
                <select class="form-control" id="dui_cliente" name="dui_cliente">
                    <option value="0">Seleccione</option>
                    <?php foreach ($query as $row): ?>
                        <option value="<?=$row["dui_cliente"]?>"><?=$row["dui_cliente"]?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("equipo-form");

        form.addEventListener("submit", function (event) {
            if (!validateForm()) {
                event.preventDefault(); // Evita el envío del formulario si no pasa la validación
            }
        });

        function validateForm() {
    const marca = document.getElementById("marca");
    const procesador = document.getElementById("procesador");
    const ram = document.getElementById("ram");
    const almacenamiento = document.getElementById("almacenamiento");
    const observaciones = document.getElementById("observaciones");
    const fechaEntrega = document.getElementById("fecha_entrega");
    const duiCliente = document.getElementById("dui_cliente");


     if (marca.value === "") {
        swal("Aviso", "Por favor, ingrese la Marca y modelo.", "warning");
        return false;
    }  else if (procesador.value === "") {
        swal("Aviso", "Por favor, ingrese el Procesador.", "warning");
        return false;
    } else if (ram.value === "") {
        swal("Aviso", "Por favor, ingrese la Memoria RAM.", "warning");
        return false;
    } else if (almacenamiento.value === "") {
        swal("Aviso", "Por favor, ingrese el Almacenamiento.", "warning");
        return false;
    } else if (observaciones.value === "") {
        swal("Aviso", "Por favor, ingrese Observaciones.", "warning");
        return false;
    } else if (!fechaEntrega.value) {
        swal("Aviso", "Por favor, seleccione una Fecha de Entrega.", "warning");
        return false;
    }else if (duiCliente.value === "0") {
        swal("Aviso", "Por favor, seleccione un DUI de Cliente.", "warning");
        return false;
    }


    return true;
}


    });
    </script>
</body>
</html>
