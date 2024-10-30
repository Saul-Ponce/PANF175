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
include "../controladores/ControladorProducto.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
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
    <script src="../assets/js/light-bootstrap-dashboard.js " type="text/javascript"></script>

</head>


<body>
    <?php
include '../includes/sidebar.php';
?>
    <div class="main-panel">
    <div class="container-fluid mt-4 ">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Productos</h3>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Codigo Producto</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Nombre Producto</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Marca</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Precio</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Stock</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Categoria</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Proveedor</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Imagen del producto</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorProducto::listar() as $row): ?>
                            <tr>
                                <td> <?=$row["codigo_producto"]?></td>
                                <td><?=$row["nombre_p"]?> </td>
                                <td><?=$row["marca"]?></td>
                                <td>$ <?=$row["precio"]?></td>
                                <td><?=$row["stock"]?></td>
                                <td><?=$row["nombre"]?></td>
                                <td><?=$row["proveedor"]?></td>
                                <td><img src="../controladores/<?=$row["imagen_p"]?>" style="max-width: 100px; max-height: 100px;"></td>

                                <th>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#editarProducto<?php echo $row['codigo_producto']; ?>"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button  class="btn btn-danger" data-toggle="modal" data-target="#eliminarProducto<?php echo $row['codigo_producto']; ?>"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </th>
                            </tr>
                            <?php include '../vistas/Modals/ModalEditarProducto.php';
?>
                        <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->

    <?php foreach (ControladorProducto::listar() as $row): ?>
        <?php include '../vistas/Modals/ModalEliminarProducto.php';?>
    <?php endforeach;?>





</body>

</html>