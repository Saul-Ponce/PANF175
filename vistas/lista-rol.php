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

require_once "../models/conexion.php";
$con = connection();
$sql = "SELECT * FROM roles";
$query = mysqli_query($con, $sql);

include "../controladores/ControladorRol.php";
include_once "../models/RolModel.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Roles</title>
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
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Roles</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size:13px !important;" scope="col">
                                        Nombre</th>
                                    <th style="font-size:13px !important;" scope="col">Descripcion</th>
                                    <th style="font-size:13px !important;" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$resultado = ControladorRol::listar();
while ($row = mysqli_fetch_assoc($resultado)): ?>
                                <tr>
                                    <td>
                                        <?=$row["nombre"]?>
                                    </td>
                                    <td>
                                        <?=$row["descripcion"]?>
                                    </td>
                                    <th>
                                        <div class="d-flex justify-content-center">

                                            <button type="button" onclick='editar(<?=json_encode($row)?>)'
                                                id="btn-editar" class="btn btn-warning me-2" data-bs-toggle="modal"
                                                data-bs-target="#mdRol">

                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-danger " data-bs-toggle="modal"
                                                data-bs-target="#mdRol" onclick='eliminar(<?=json_encode($row)?>)'>
                                                <i class="fa-solid fa-trash"></i></button>
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
    <?php include '../vistas/Modals/ModalRol.php';?>

    <script>
    function editar(data) {
        document.getElementById("nombre").removeAttribute("disabled", "");
        document.getElementById("descripcion").removeAttribute("disabled", "");

        document.getElementById("action").value = "editar";
        document.getElementById("id").value = data.id || "";
        document.getElementById("nombre").value = data.nombre || "";
        document.getElementById("descripcion").value = data.descripcion || "";
        document.getElementById("enviar").innerHTML = "Guardar Cambios";
        document.getElementById("enviar").classList.remove('btn-danger');
        document.getElementById("enviar").classList.add('btn-primary');

    }

    function eliminar(data) {
        document.getElementById("titulo").innerHTML = "¿SEGURO QUE DESEA BORRAR ESTE ROL?";

        document.getElementById("nombre").setAttribute("disabled", "");
        document.getElementById("descripcion").setAttribute("disabled", "");

        document.getElementById("action").value = "borrar";
        document.getElementById("id").value = data.id || "";
        document.getElementById("nombre").value = data.nombre || "";
        document.getElementById("descripcion").value = data.descripcion || "";
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