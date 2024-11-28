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
include "../controladores/ControladorCatalogoActivoFijo.php";
include_once "../models/CatalogoActivoFijoModel.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Catalogo activo fijo</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>

    <div class="main-panel">
        <div class="container mt-4 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Catalogo Activo fijo</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size:13px !important;" scope="col">Nombre</th>
                                    <th style="font-size:13px !important;" scope="col">Descripcion</th>
                                    <th style="font-size:13px !important;" scope="col">Procentaje depreciacion</th>
                                    <th style="font-size:13px !important;" scope="col">Codigo</th>
                                    <th style="font-size:13px !important;" scope="col">Estado</th>
                                    <th style="font-size:13px !important;" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorCatalogoActivoFijo::listar();
                                while ($row = mysqli_fetch_assoc($resultado)): ?>
                                    <tr>
                                        <td><?= $row["nombreActivo"] ?></td>
                                        <td><?= $row["descripcion"] ?></td>
                                        <td><?= $row["porcentajeDepreciacion"] ?>%</td>
                                        <td><?= $row["codigo"] ?></td>
                                        <td><?= $row["estado"] ? '<span class="badge bg-green text-green-fg">Activo</span>' : '<span class="badge bg-red text-red-fg">Inactivo</span>' ?></td>
                                        <th>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" onclick='editar(<?= json_encode($row) ?>)'
                                                    id="btn-editar" class="btn btn-warning me-2" data-bs-toggle="modal"
                                                    title="modificar"
                                                    data-bs-target="#mdCatalogoActivofijo">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <?php if ($_SESSION['rol'] == "Administrador"): ?>
                                                    <button class="btn <?= $row["estado"] ? 'btn-danger' : 'btn-success' ?> me-2 "
                                                        onclick='cambiarEstado(<?= json_encode($row) ?>)'
                                                        title="<?= $row["estado"] ? 'Dar de baja' : 'Dar de alta' ?>"
                                                        data-bs-toggle="modal" data-bs-target="#mdCatalogoActivofijo">
                                                        <?= $row["estado"] ? '<i class="fa fa-user-times" aria-hidden="true"></i>' :
                                                            '<i class="fa fa-user" aria-hidden="true"></i>' ?>
                                                    </button>
                                                <?php endif ?>
                                            </div>
                                        </th>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../layouts/Footer.php'; ?>
    </div>
    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>
    <?php include '../vistas/Modals/ModalEditarCatalogoActivoFijo.php'; ?>
    <script>
        function editar(data) {
            console.log(data);
            document.getElementById("titulo").innerHTML = "Editar catalogo tipos de activo"
            document.getElementById("nombreActivo").removeAttribute("disabled", "");
            document.getElementById("porcentajeDepreciacion").removeAttribute("disabled", "");
            document.getElementById("descripcion").removeAttribute("disabled", "");
            // Asignar valores a los campos del formulario del modal
            document.getElementById("action").value = "editar"; // Acción para el controlador
            document.getElementById("idTipoActivo").value = data.idTipoActivo || ""; // ID del registro a editar
            document.getElementById("nombreActivo").value = data.nombreActivo || ""; // Nombre
            document.getElementById("porcentajeDepreciacion").value = data.porcentajeDepreciacion || ""; // Porcentaje de depreciación
            document.getElementById("descripcion").value = data.descripcion || ""; // Descripción
            document.getElementById("codigo").value = data.codigo || ""; // Codigo
            // Cambiar el texto y la clase del botón de enviar
            document.getElementById("enviar").innerHTML = "Guardar Cambios";
            document.getElementById("enviar").classList.remove('btn-danger');
            document.getElementById("enviar").classList.add('btn-primary');
        }

        function cambiarEstado(data) {
            console.log(data);
            document.getElementById("titulo").innerHTML = data.estado == "1" ?
                '¿SEGURO QUE DESEA DAR DE BAJA A ESTE TIPO DE ACTIVO?' : '¿SEGURO QUE DESEA ACTIVAR A ESTE TIPO DE ACTIVO?';
            document.getElementById("nombreActivo").setAttribute("disabled", "");
            document.getElementById("porcentajeDepreciacion").setAttribute("disabled", "");
            document.getElementById("descripcion").setAttribute("disabled", "");
            document.getElementById("codigo").setAttribute("disabled", "");
            document.getElementById("action").value = "cambiarEstado";
            document.getElementById("idTipoActivo").value = data.idTipoActivo || "";
            document.getElementById("nombreActivo").value = data.nombreActivo || "";
            document.getElementById("porcentajeDepreciacion").value = data.porcentajeDepreciacion || "";
            document.getElementById("descripcion").value = data.descripcion || "";
            document.getElementById("codigo").value = data.codigo || ""; // Codigo
            document.getElementById("estado").value = data.estado == 1 ? false : true || ""; /// para dar de daba enviamos el estado del activo pero lo recive un input oculto
            document.getElementById("enviar").innerHTML = data.estado == 1 ? "Dar de baja" : "Activar";
            if (data.estado == 1) {
                document.getElementById("enviar").classList.remove('btn-primary');
                document.getElementById("enviar").classList.add('btn-danger');
            } else {
                document.getElementById("enviar").classList.remove('btn-danger');
                document.getElementById("enviar").classList.add('btn-primary');
            }
        }
        // Check if a success message is set in the session
        <?php if (isset($_SESSION['success_messageP'])): ?>
            Swal.fire('<?php echo $_SESSION['success_messageP']; ?>', '', 'success');
            <?php unset($_SESSION['success_messageP']); // Clear the message 
            ?>
        <?php endif; ?>
    </script>
</body>

</html>