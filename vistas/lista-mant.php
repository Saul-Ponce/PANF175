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
include "../controladores/ControladorMant.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Mantenimiento</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="../assets/js/plugins/bootstrap-switch.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>

</head>



<body>
    <?php
include '../includes/sidebar.php';
?>
    <div class="main-panel">
        <div class="container-fluid mt-4 ">

            <div class="card">
                <div class="card-body">
                    <h3 class="text-center align-middle card-title" style="font-weight: 700;">Control de mantenimiento</h3>
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>

                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Marca</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Procesador</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Ram</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Almacenamiento</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Dueño</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Fecha de mantenimiento</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Detalles</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">precio</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Estado</th>
                                <th scope="col"><i class="fa-solid fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (ControladorMant::listar() as $row): ?>
                                <tr>
                                    <td> <?=$row["marca"]?></td>
                                    <td> <?=$row["procesador"]?></td>
                                    <td> <?=$row["ram"]?></td>
                                    <td> <?=$row["almacenamiento"]?></td>
                                    <td> <?=$row["nombre_c"] . ' ' . $row["apellido_c"]?></td>
                                    <td> <?=date('d-m-Y', strtotime($row["fecha_m"]))?></td>
                                    <td> <?=$row["detalles_m"]?></td>
                                    <td> $<?=$row["precio_m"]?></td>

                                    <td> <?php if ($row['estado_m'] === 'Finalizado'): ?>
                                            <span class="badge badge-danger"><?=$row['estado_m']?></span>
                                        <?php else: ?>
                                            <span class="badge badge-primary"><?=$row['estado_m']?></span>
                                        <?php endif;?>
                                    </td>

                                    <th>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-warning mr-1" onclick="openModal('edit-mantModal<?php echo $row['id_cmantenimiento']; ?>')">
                                                <i class="fa-regular fa-pen-to-square"></i></button>
                                            <button class="btn btn-danger" onclick="openModal('EliminarMant<?php echo $row['id_cmantenimiento']; ?>')">
                                                <i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </th>
                                </tr>

                            <?php
include '../vistas/modals/ModalEditarMant.php';
include '../vistas/modals/ModalEliminarMant.php';
endforeach;?>

                        </tbody>
                    </table>

                    <div clas="d-flex align-content-center">
                        <!-- Button trigger modal -->



                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

<script>
    function openModal(modalId) {
        var modal = document.getElementById(modalId);
        $(modal).modal('show'); // Using jQuery to open the modal
    }
</script>

<script>
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageM'])): ?>
        Swal.fire('<?php echo $_SESSION['success_messageM']; ?>', '', 'success');
        <?php unset($_SESSION['success_messageM']); // Clear the message ?>
    <?php endif;?>
</script>

</html>