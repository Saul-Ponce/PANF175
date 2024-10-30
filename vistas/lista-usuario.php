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

include "../controladores/ControladorUsuario.php";
include_once "../models/UsuarioModel.php";

?>
<!DOCTYPE html>
<html lang="es">

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
        <div class="container-fluid mt-4 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Usuarios</h3>
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important;" scope="col">
                                    Nombre</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; "
                                    scope="col">Usuario</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; "
                                    scope="col">Rol</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; "
                                    scope="col">Correo de Recuperacion</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; "
                                    scope="col">Estado</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; "
                                    scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$resultado = ControladorUsuario::listar();
while ($row = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td>
                                    <?=$row["nombre"]?>
                                </td>
                                <td><?=$row["usuario"]?></td>
                                <td>
                                    <?=$row["nombre_rol"]?>
                                </td>
                                <td>
                                    <?=$row["correo_recuperacion"]?>
                                </td>
                                <td>
                                    <?=$row["estado"] ? '<span class="badge bg-green text-green-fg">Activo</span>' : '<span class="badge bg-red text-red-fg">Inactivo</span>'?>
                                </td>
                                <th>
                                    <div class="d-flex justify-content-center">

                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editarUsuario<?php echo $row['id']; ?>"><i
                                                class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="btn <?=$row["estado"] ? 'btn-danger' : 'btn-success'?> mx-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#estadoUsuario<?php echo $row['id']; ?>">
                                            <?=$row["estado"] ? '<i class="fa fa-user-times" aria-hidden="true"></i>' : '<i class="fa fa-user" aria-hidden="true"></i>'?></button>
                                        <button class="btn btn-danger " data-bs-toggle="modal"
                                            data-bs-target="#eliminarUsuario<?php echo $row['id']; ?>"> <i
                                                class="fa-solid fa-trash"></i></button>
                                    </div>
                                </th>
                            </tr>

                            <?php include '../vistas/Modals/ModalEditarUsuario.php';?>

                            <?php endwhile;?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php';?>


    <?php foreach (ControladorUsuario::listar() as $row): ?>
    <?php include '../vistas/Modals/ModalEstadoUsuario.php';?>
    <?php include '../vistas/Modals/ModalEliminarUsuario.php';?>

    <?php endforeach;?>



    <script>
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageP'])): ?>
    Swal.fire('<?php echo $_SESSION['success_messageP']; ?>', '', 'success');
    <?php unset($_SESSION['success_messageP']); // Clear the message ?>
    <?php endif;?>
    </script>
</body>

</html>