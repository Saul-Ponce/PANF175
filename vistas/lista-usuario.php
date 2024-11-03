<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
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
        <div class="container mt-4 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Usuarios</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size:13px !important;" scope="col">
                                        Nombre</th>
                                    <th style="font-size:13px !important;" scope="col">Usuario</th>
                                    <th style="font-size:13px !important;" scope="col">Rol</th>
                                    <th style="font-size:13px !important;" scope="col">Correo de Recuperacion</th>
                                    <th style="font-size:13px !important;" scope="col">Estado</th>
                                    <th style="font-size:13px !important;" scope="col">Acciones</th>
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

                                            <button type="button" onclick='editar(<?=json_encode($row)?>)'
                                                id="btn-editar" class="btn btn-warning me-2" data-bs-toggle="modal"
                                                data-bs-target="#mdUsuario">

                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <?php if ($row['usuario'] != $_SESSION['usuario']): ?>
                                            <?php if ($row['nombre_rol'] != "Administrador"): ?>
                                            <button class="btn <?=$row["estado"] ? 'btn-danger' : 'btn-success'?> me-2"
                                                data-bs-toggle="modal" data-bs-target="#mdUsuario"
                                                onclick='cambiarEstado(<?=json_encode($row)?>)'>
                                                <?=$row["estado"] ? '<i class="fa fa-user-times" aria-hidden="true"></i>' : '<i class="fa fa-user" aria-hidden="true"></i>'?></button>
                                            <?php endif?>
                                            <button class="btn btn-danger " data-bs-toggle="modal"
                                                data-bs-target="#mdUsuario" onclick='eliminar(<?=json_encode($row)?>)'>
                                                <i class="fa-solid fa-trash"></i></button>
                                            <?php endif?>
                                        </div>
                                    </th>
                                </tr>
                                <?php endwhile;?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../layouts/Footer.php';?>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php';?>

    <?php include '../vistas/Modals/ModalUsuario.php';?>

    <script>
    function editar(data) {
        document.getElementById("nombre").removeAttribute("disabled", "");
        document.getElementById("usuario").removeAttribute("disabled", "");
        document.getElementById("correo-recuperacion").removeAttribute("disabled", "");
        document.getElementById("rol-id").removeAttribute("disabled", "");

        document.getElementById("action").value = "editar";
        document.getElementById("id").value = data.id || "";
        document.getElementById("nombre").value = data.nombre || "";
        document.getElementById("usuario").value = data.usuario || "";
        document.getElementById("correo-recuperacion").value = data.correo_recuperacion || "";
        document.getElementById("rol-id").value = data.rol_id || "";
        document.getElementById("enviar").innerHTML = "Guardar Cambios";
        document.getElementById("enviar").classList.remove('btn-danger');
        document.getElementById("enviar").classList.add('btn-primary');

    }

    function cambiarEstado(data) {
        document.getElementById("titulo").innerHTML = data.estado == "1" ?
            '¿SEGURO QUE DESEA DAR DE BAJA A ESTE USUARIO?' : '¿SEGURO QUE DESEA ACTIVAR A ESTE USUARIO?';

        document.getElementById("nombre").setAttribute("disabled", "");
        document.getElementById("usuario").setAttribute("disabled", "");
        document.getElementById("correo-recuperacion").setAttribute("disabled", "");
        document.getElementById("rol-id").setAttribute("disabled", "");

        document.getElementById("action").value = "cambiarEstado";
        document.getElementById("id").value = data.id || "";
        document.getElementById("estado").value = data.estado == 1 ? false : true || "";
        document.getElementById("nombre").value = data.nombre || "";
        document.getElementById("usuario").value = data.usuario || "";
        document.getElementById("correo-recuperacion").value = data.correo_recuperacion || "";
        document.getElementById("rol-id").value = data.rol_id || "";
        document.getElementById("enviar").innerHTML = data.estado == 1 ? "Dar de baja" : "Activar";

        if (data.estado == 1) {
            document.getElementById("enviar").classList.remove('btn-primary');
            document.getElementById("enviar").classList.add('btn-danger');

        } else {
            document.getElementById("enviar").classList.remove('btn-danger');
            document.getElementById("enviar").classList.add('btn-primary');

        }

    }

    function eliminar(data) {
        document.getElementById("titulo").innerHTML = "¿SEGURO QUE DESEA BORRAR ESTE USUARIO?";

        document.getElementById("nombre").setAttribute("disabled", "");
        document.getElementById("usuario").setAttribute("disabled", "");
        document.getElementById("correo-recuperacion").setAttribute("disabled", "");
        document.getElementById("rol-id").setAttribute("disabled", "");

        document.getElementById("action").value = "borrar";
        document.getElementById("id").value = data.id || "";
        document.getElementById("nombre").value = data.nombre || "";
        document.getElementById("usuario").value = data.usuario || "";
        document.getElementById("correo-recuperacion").value = data.correo_recuperacion || "";
        document.getElementById("rol-id").value = data.rol_id || "";
        document.getElementById("enviar").innerHTML = "Eliminar";
        document.getElementById("enviar").classList.remove('btn-primary');
        document.getElementById("enviar").classList.add('btn-danger');

    }
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageP'])): ?>
    Swal.fire('<?php echo $_SESSION['success_messageP']; ?>', '', 'success');
    <?php unset($_SESSION['success_messageP']); // Clear the message ?>
    <?php endif;?>
    </script>
</body>

</html>