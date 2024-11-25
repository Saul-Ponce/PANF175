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
include "../controladores/ControladorActivoFijo.php";
include_once "../models/ActivoFijoModel.php";
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
                    <!-- Botón para redirigir a la página del formulario -->
                    <div class="d-flex justify-content-end mb-3">
                        <a href="../vistas/registrar_activoFijo.php" class="btn btn-primary">
                            Agregar Activo Fijo
                        </a>
                    </div>
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Activo fijo</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-size:13px !important;" scope="col">Codigo</th>
                                    <th style="font-size:13px !important;" scope="col">Nombre</th>
                                    <th style="font-size:13px !important;" scope="col">Tipo</th>
                                    <th style="font-size:13px !important;" scope="col">Fecha</th>
                                    <th style="font-size:13px !important;" scope="col">Valor</th>
                                    <th style="font-size:13px !important;" scope="col">Vida util</th>
                                    <th style="font-size:13px !important;" scope="col">Estado</th>
                                    <th style="font-size:13px !important;" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorActivoFijo::listar();
                                while ($row = mysqli_fetch_assoc($resultado)): ?>
                                    <tr>
                                        <td><?= $row["codigo"] ?></td>
                                        <td><?= $row["nombre"] ?></td>
                                        <td><?= $row["nombreActivo"] ?></td>
                                        <td><?= $row["fecha_adquisicion"] ?></td>
                                        <td><?= "$" . number_format($row["valor_adquisicion"], 2) ?></td>
                                        <td><?= $row["vida_util"] . " años" ?></td>
                                        <td>
                                            <?php
                                            $estadoActivo = $row["estadoActivo"];
                                            $estadoTexto = '';

                                            // Determina el estado descriptivo
                                            switch ($estadoActivo) {
                                                case 1:
                                                    $estadoTexto = "Nuevo";
                                                    break;
                                                case 3:
                                                    $estadoTexto = "Mantenimiento";
                                                    break;
                                                case 5:
                                                    $estadoTexto = "Donado";
                                                    break;
                                                case 6:
                                                    $estadoTexto = "Vendido";
                                                    break;
                                                case 7:
                                                    $estadoTexto = "Votado (Desechado)";
                                                    break;
                                                case 8:
                                                    $estadoTexto = "Pendiente de Revisión";
                                                    break;
                                                case 9:
                                                    $estadoTexto = "Obsoleto";
                                                    break;
                                                default:
                                                    $estadoTexto = "Desconocido";
                                            }

                                            // Determina si es activo o inactivo
                                            $activoInactivo = $row["estado"] ? '<span class="badge bg-green text-green-fg">Activo</span>' : '<span class="badge bg-red text-red-fg">Inactivo</span>';

                                            echo $estadoTexto .  $activoInactivo;
                                            ?>
                                        </td>


                                        <th>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" onclick='editar(<?= json_encode($row) ?>)'
                                                    id="btn-editar" class="btn btn-warning me-1" data-bs-toggle="modal"
                                                    title="modificar"
                                                    data-bs-target="#mdActivofijo">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <?php if ($_SESSION['rol'] == "Administrador"): ?>
                                                    <button class="btn <?= $row["estado"] ? 'btn-danger' : 'btn-success' ?> me-1"
                                                        data-bs-toggle="modal" data-bs-target="#mdActivofijo"
                                                        onclick='cambiarEstado(<?= json_encode($row) ?>)'>
                                                        <?= $row["estado"] ? '<i class="fa fa-user-times" aria-hidden="true"></i>' : '<i class="fa fa-user" aria-hidden="true"></i>' ?></button>
                                                    <button class="btn btn-danger " data-bs-toggle="modal"
                                                        data-bs-target="#mdActivofijo" onclick='eliminar(<?= json_encode($row) ?>)'>
                                                        <i class="fa-solid fa-trash"></i></button>
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
    <?php include '../vistas/Modals/ModalEditarActivoFijo.php'; ?>
    <script>
        function editar(data) {
            console.log(data);
            document.getElementById("titulo").innerHTML = "Editar activo fijo"
            // Asignar valores a los campos del formulario del modal
            document.getElementById("action").value = "editar";
            document.getElementById("id_activo").value = data.id_activo || "";
            document.getElementById("codigoUnidad").value = data.codigoUnidad || "";
            document.getElementById("nombre").value = data.nombre || "";
            document.getElementById("idTipoActivo").value = data.idTipoActivo || "";
            document.getElementById("fecha_adquisicion").value = data.fecha_adquisicion || "";
            document.getElementById("valor_adquisicion").value = data.valor_adquisicion || "";
            document.getElementById("vida_util").value = data.vida_util || "";
            document.getElementById("estadoActivo").value = data.estadoActivo || "";
            document.getElementById("codigo").value = data.codigo || "";
            // Cambiar el texto y la clase del botón de enviar
            document.getElementById("enviar").innerHTML = "Guardar Cambios";
            document.getElementById("enviar").classList.remove('btn-danger');
            document.getElementById("enviar").classList.add('btn-primary');
        }

        function eliminar(data) {
            console.log(data);
            document.getElementById("titulo").innerHTML = "¿SEGURO QUE DESEA BORRAR ESTE ACTIVO?";
            document.getElementById("codigoUnidad").setAttribute("disabled", "");
            document.getElementById("nombre").setAttribute("disabled", "");
            document.getElementById("idTipoActivo").setAttribute("disabled", "");
            document.getElementById("fecha_adquisicion").setAttribute("disabled", "");
            document.getElementById("valor_adquisicion").setAttribute("disabled", "");
            document.getElementById("vida_util").setAttribute("disabled", "");
            document.getElementById("estadoActivo").setAttribute("disabled", "");

            document.getElementById("action").value = "borrar";
            document.getElementById("id_activo").value = data.id_activo || "";
            document.getElementById("codigoUnidad").value = data.codigoUnidad || "";
            document.getElementById("nombre").value = data.nombre || "";
            document.getElementById("idTipoActivo").value = data.idTipoActivo || "";
            document.getElementById("fecha_adquisicion").value = data.fecha_adquisicion || "";
            document.getElementById("valor_adquisicion").value = data.valor_adquisicion || "";
            document.getElementById("vida_util").value = data.vida_util || "";
            document.getElementById("estadoActivo").value = data.estadoActivo || "";
            document.getElementById("codigo").value = data.codigo || "";
            document.getElementById("enviar").innerHTML = "Eliminar";
            document.getElementById("enviar").classList.remove('btn-primary');
            document.getElementById("enviar").classList.add('btn-danger');
        }

        function cambiarEstado(data) {
            document.getElementById("titulo").innerHTML = data.estado == "1" ?
                '¿SEGURO QUE DESEA DAR DE BAJA A ESTE ACTIVO FIJO?' : '¿SEGURO QUE DESEA ACTIVAR A ESTE ACTIVO FIJO?';

            document.getElementById("codigoUnidad").setAttribute("disabled", "");
            document.getElementById("nombre").setAttribute("disabled", "");
            document.getElementById("idTipoActivo").setAttribute("disabled", "");
            document.getElementById("fecha_adquisicion").setAttribute("disabled", "");
            document.getElementById("valor_adquisicion").setAttribute("disabled", "");
            document.getElementById("vida_util").setAttribute("disabled", "");
            document.getElementById("estadoActivo").setAttribute("disabled", "");

            document.getElementById("id_activo").value = data.id_activo || "";
            document.getElementById("codigoUnidad").value = data.codigoUnidad || "";
            document.getElementById("nombre").value = data.nombre || "";
            document.getElementById("idTipoActivo").value = data.idTipoActivo || "";
            document.getElementById("fecha_adquisicion").value = data.fecha_adquisicion || "";
            document.getElementById("valor_adquisicion").value = data.valor_adquisicion || "";
            document.getElementById("vida_util").value = data.vida_util || "";
            document.getElementById("estadoActivo").value = data.estadoActivo || "";
            document.getElementById("action").value = "cambiarEstado";
            document.getElementById("estado").value = data.estado == 1 ? false : true || "";
            document.getElementById("enviar").innerHTML = data.estado == 1 ? "Dar de baja" : "Activar";
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