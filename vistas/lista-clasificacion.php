<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        window.location = "../index.php"
    </script>
    ';
    session_destroy();
    die();
}
include("../controladores/ControladorClasificacion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Usuarios</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php';?>
</head>
<body>
<?php include '../layouts/Navbar.php';?>
<div class="main-panel">
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Clasificaciones</h3>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Nombre</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Descripción</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">Acciones</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorClasificacion::listar() as $row): ?>
                            <tr>
                                <td><?= $row["nombre"] ?></td>
                                <td><?= $row["descripcion"] ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                            data-target="#editarClasificacion<?php echo $row['id']; ?>">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#eliminarClasificacion<?php echo $row['id']; ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                include('../vistas/modals/ModalEditarClasificacion.php');
                                include('../vistas/modals/ModalEliminarClasificacion.php'); 
                            endforeach; ?>
                    </tbody>
                </table>

                <div class="d-flex align-content-center">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#clasificacionModal">
                        Agregar Clasificación
                    </button>
                    <?php include('../vistas/modals/ModalAgregarClasificacion.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../layouts/footerScript.php';?>
<script>
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_message'])) : ?>
        Swal.fire('<?php echo $_SESSION['success_message']; ?>', '', 'success');
        <?php unset($_SESSION['success_message']); // Clear the message ?>
    <?php endif; ?>
</script>
</body>
</html>
