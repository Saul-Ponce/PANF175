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
include "../controladores/ControladorRol.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Roles</title>
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
<?php include '../includes/sidebar.php';?>
<div class="main-panel">
    <div class="container-fluid mt-4 "  >

        <div class="card">
            <div class="card-body">

                <h3 class="card-title text-center align-middle"  style="font-weight: 700;">Lista de Roles</h3>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>


                            <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col" >Rol</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col" >Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach (ControladorRol::listar() as $row): ?>
                            <tr>

                                <td> <?=$row["nombre_rol"]?></td>

                                <th>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning " data-toggle="modal"
                                            data-target="#edit-rolModal<?php echo $row['id_rol']; ?>">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#ModalEliminarRol<?php echo $row['id_rol']; ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </th>
                            </tr>

                        <?php
include '../vistas/modals/editar-rol.php';
include '../vistas/modals/ModalEliminarRol.php';
endforeach;?>

                    </tbody>
                </table>

                <div clas="d-flex align-content-center">
                <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rolModal">
  Agregar rol
</button>


<?php include '../vistas/modals/rol.php';

?>



                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageR'])): ?>
        Swal.fire('<?php echo $_SESSION['success_messageR']; ?>', '', 'success');
        <?php unset($_SESSION['success_messageR']); // Clear the message ?>
    <?php endif;?>
</script>

</body>

</html>
