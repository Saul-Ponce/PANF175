<?php
include "../controladores/ControladorEquipo.php";

include "../controladores/ControladorMant.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Equipos</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- CSS Files -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />

  <!--   Core JS Files   -->

  <script src="../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../assets/js/plugins/bootstrap-switch.js"></script>

<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../assets/js/light-bootstrap-dashboard.js " type="text/javascript"></script>


</head>

<body>
<?php include '../includes/sidebar.php';?>

<div class="main-panel">
    <div class="container-fluid mt-4 ">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center align-middle"  style="font-weight: 700;">Lista de Equipos</h3>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Fecha de recibido</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Marca</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Procesador</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">RAM</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Almacenamiento</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Observaciones</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Fecha de Entrega</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">DUI de cliente</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorEquipo::listar() as $row): ?>
                            <tr>
                                <td><?=date('d-m-Y', strtotime($row["fecha_r"]))?></td>
                                <td><?=$row["marca"]?></td>
                                <td><?=$row["procesador"]?></td>
                                <td><?=$row["ram"]?></td>
                                <td><?=$row["almacenamiento"]?></td>
                                <td><?=$row["observaciones"]?> </td>
                                <td><?=date('d-m-Y', strtotime($row["fecha_entrega"]))?></td>
                                <td><?=$row["dui_cliente"]?>
                                </td>

                                <th>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning mr-1" onclick="openModal('editarEquipo<?php echo $row['id_equipo']; ?>')"> <i class="fa-regular fa-pen-to-square"></i></button>
                                        <button type="button" class="btn btn-danger mr-1" onclick="openModal('eliminarEquipo<?php echo $row['id_equipo']; ?>')"><i class="fa-solid fa-trash"></i></button>
                                        <button type="button" class="btn btn-success" onclick="openModal('addMant<?php echo $row['id_equipo']; ?>')"> <i class="fa-solid fa-screwdriver-wrench"></i></button>
                                    </div>
                                </th>
                            </tr>
                            <?php

include '../vistas/Modals/ModalEditarEquipo.php';

endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <script>
    function openModal(modalId) {
    var modal = document.getElementById(modalId);
    $(modal).modal('show'); // Using jQuery to open the modal
}
</script>


    <?php foreach (ControladorEquipo::listar() as $row): ?>
        <?php
include '../vistas/modals/ModalAddMant.php';
include '../vistas/Modals/ModalEliminarEquipo.php'?>
    <?php endforeach;?>







</body>

</html>