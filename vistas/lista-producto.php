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


include "../controladores/ControladorProducto.php";
include_once "../models/ProductoModel.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Productos</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./../public/assets/libs/datatables/datatables.min.js"></script>
    <div class="main-panel">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Productos</h3>
                    <div class="table-responsive">
                        <table id="tabla-producto" class="table table-bordered text-center align-middle datatable">
                            <thead>
                                <tr>
                                    <th style="font-size:13px !important;" scope="col">Código</th>
                                    <th style="font-size:13px !important;" scope="col">Nombre</th>
                                    <th style="font-size:13px !important;" scope="col">Descripcion</th>
                                    <th style="font-size:13px !important;" scope="col">Categoria</th>
                                    <th style="font-size:13px !important;" scope="col">Imagen</th>
                                    <th style="font-size:13px !important;" scope="col">Marca</th>
                                    <th style="font-size:13px !important;" scope="col">Modelo</th>
                                    <th style="font-size:13px !important;" scope="col">Stock Minimo</th>
                                    <th style="font-size:13px !important;" scope="col">Stock Maximo</th>
                                    <th style="font-size:13px !important;" scope="col">Clasificación</th>
                                    <th style="font-size:13px !important;" scope="col">Estado</th>
                                    <th style="font-size:13px !important;" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorProducto::listar();

                                while ($row = mysqli_fetch_assoc($resultado)):
                                ?>

                                    <tr>
                                    <td><?= $row["codigo"] ?></td>
                                        <td>
                                            <?= $row["pnombre"] ?>
                                        </td>
                                        <td><?= $row["pdescripcion"] ?></td>
                                        <td><?= $row["cnombre"] ?></td>
                                        <td><img src="../controladores/<?= $row["imagen"] ?>" style="max-width: 100px; max-height: 100px;"></td>
                                        <td><?= $row["marca"] ?></td>
                                        <td><?= $row["modelo"] ?></td>
                                        <td><?= $row["stock_minimo"] ?></td>
                                        <td><?= $row["stok_maximo"] ?></td>
                                        <td><?= $row["clasificacion"] ?></td>
                                        <td>
                                            <?= $row["pestado"] ? '<span class="badge bg-green text-green-fg">Activo</span>' : '<span class="badge bg-red text-red-fg">Inactivo</span>' ?>
                                        </td>
                                        <th>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" onclick='editar(<?= json_encode($row) ?>)'
                                                    id="btn-editar" class="btn btn-warning me-2" data-bs-toggle="modal"
                                                    title="modificar"
                                                    data-bs-target="#mdProducto">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <?php if ($_SESSION['rol'] == "Administrador"): ?>
                                                    <button class="btn <?= $row["pestado"] ? 'btn-danger' : 'btn-success' ?> me-2 "
                                                        onclick='cambiarEstado(<?= json_encode($row) ?>)'
                                                        title="<?= $row["pestado"] ? 'Dar de baja' : 'Dar de alta' ?>"
                                                        data-bs-toggle="modal" data-bs-target="#mdProducto">
                                                        <?= $row["pestado"] ? '<i class="fa fa-user-times" aria-hidden="true"></i>' :
                                                            '<i class="fa fa-user" aria-hidden="true"></i>' ?>
                                                    </button>
                                                    <button class="btn btn-danger " data-bs-toggle="modal"
                                                        data-bs-target="#mdProducto" onclick='eliminar(<?= json_encode($row) ?>)'>
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

    <?php include '../vistas/Modals/ModalProducto.php'; ?>

    <script src="../public/assets/js/toast.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabla-producto').DataTable({
                "language": {
                    "url": "./../public/assets/libs/datatables/esp.json"
                },
            });
        });

        
        // Check if a success message is set in the session
        <?php if (isset($_SESSION['success_messageP'])): ?>

            Toast.fire({
                icon: "success",
                title: "<?php echo $_SESSION['success_messageP']; ?>"
            });
        <?php unset($_SESSION['success_messageP']); // Clear the message ?> <?php endif; ?> <?php if (isset($_SESSION['info_messageP'])): ?> console
                .log('si vinos');

            Toast.fire({
                icon: "info",
                title: "<?php echo $_SESSION['info_messageP']; ?>"
            });
        <?php unset($_SESSION['success_messageP']); // Clear the message ?> <?php endif; ?>
            </script>
    <script>
        function editar(data) {
            document.getElementById("codigo").removeAttribute("disabled", "");
            document.getElementById("nombre").removeAttribute("disabled", "");
            document.getElementById("descripcion").removeAttribute("disabled", "");
            document.getElementById("categoria_id").removeAttribute("disabled", "");
            document.getElementById("imagen").removeAttribute("disabled", "");
            document.getElementById("marca").removeAttribute("disabled", "");
            document.getElementById("modelo").removeAttribute("disabled", "");
            document.getElementById("stock_minimo").removeAttribute("disabled", "");
            document.getElementById("stock_maximo").removeAttribute("disabled", "");
            document.getElementById("clasificacion").removeAttribute("disabled", "");
            document.getElementById("action").value = "editar";

            document.getElementById("id").value = data.pid || "";
            document.getElementById("codigo").value = data.codigo || "";
            document.getElementById("nombre").value = data.pnombre || "";
            document.getElementById("descripcion").value = data.pdescripcion || "";
            document.getElementById("categoria_id").value = data.categoria_id || "";
            document.getElementById("marca").value = data.marca || "";
            document.getElementById("modelo").value = data.modelo || "";
            document.getElementById("stock_minimo").value = data.stock_minimo || "";
            document.getElementById("stock_maximo").value = data.stok_maximo || "";
            document.getElementById("clasificacion").value = data.clasificacion || "";
            document.getElementById("imagen").value = data.imagen || "";
            document.getElementById("enviar").innerHTML = "Guardar Cambios";
            document.getElementById("enviar").classList.remove('btn-danger');
            document.getElementById("enviar").classList.add('btn-primary');

        }

        function cambiarEstado(data) {
            document.getElementById("titulo").innerHTML = data.estado == "1" ?
                '¿SEGURO QUE DESEA DAR DE BAJA A ESTE PRODUCTO?' : '¿SEGURO QUE DESEA ACTIVAR A ESTE PRODUCTO?';

            document.getElementById("codigo").setAttribute("disabled", "");    
            document.getElementById("nombre").setAttribute("disabled", "");
            document.getElementById("descripcion").setAttribute("disabled", "");
            document.getElementById("categoria_id").setAttribute("disabled", "");
            document.getElementById("imagen").setAttribute("disabled", "");
            document.getElementById("marca").setAttribute("disabled", "");
            document.getElementById("modelo").setAttribute("disabled", "");
            document.getElementById("stock_minimo").setAttribute("disabled", "");
            document.getElementById("stock_maximo").setAttribute("disabled", "");
            document.getElementById("clasificacion").setAttribute("disabled", "");
            document.getElementById("action").value = "cambiarEstado";


            document.getElementById("id").value = data.pid || "";
            document.getElementById("codigo").value = data.codigo || "";
            document.getElementById("estado").value = data.pestado == 1 ? false : true || "";
            document.getElementById("nombre").value = data.pnombre || "";
            document.getElementById("descripcion").value = data.pdescripcion || "";
            document.getElementById("categoria_id").value = data.categoria_id || "";
            document.getElementById("marca").value = data.marca || "";
            document.getElementById("modelo").value = data.modelo || "";
            document.getElementById("stock_minimo").value = data.stock_minimo || "";
            document.getElementById("stock_maximo").value = data.stok_maximo || "";
            document.getElementById("clasificacion").value = data.clasificacion || "";
            document.getElementById("imagen").value = data.imagen || "";
            document.getElementById("enviar").innerHTML = data.pestado == 1 ? "Dar de baja" : "Activar";

            if (data.estado == 1) {
                document.getElementById("enviar").classList.remove('btn-primary');
                document.getElementById("enviar").classList.add('btn-danger');

            } else {
                document.getElementById("enviar").classList.remove('btn-danger');
                document.getElementById("enviar").classList.add('btn-primary');

            }

        }

        function eliminar(data) {
            document.getElementById("titulo").innerHTML = "¿SEGURO QUE DESEA BORRAR ESTE PRODUCTO?";

            document.getElementById("codigo").setAttribute("disabled", "");
            document.getElementById("nombre").setAttribute("disabled", "");
            document.getElementById("descripcion").setAttribute("disabled", "");
            document.getElementById("categoria_id").setAttribute("disabled", "");
            document.getElementById("imagen").setAttribute("disabled", "");
            document.getElementById("marca").setAttribute("disabled", "");
            document.getElementById("modelo").setAttribute("disabled", "");
            document.getElementById("stock_minimo").setAttribute("disabled", "");
            document.getElementById("stock_maximo").setAttribute("disabled", "");
            document.getElementById("clasificacion").setAttribute("disabled", "");
            document.getElementById("action").value = "borrar";

            document.getElementById("id").value = data.pid || "";
            document.getElementById("codigo").value = data.codigo || "";
            document.getElementById("nombre").value = data.pnombre || "";
            document.getElementById("descripcion").value = data.pdescripcion || "";
            document.getElementById("categoria_id").value = data.categoria_id || "";
            document.getElementById("marca").value = data.marca || "";
            document.getElementById("modelo").value = data.modelo || "";
            document.getElementById("stock_minimo").value = data.stock_minimo || "";
            document.getElementById("stock_maximo").value = data.stok_maximo || "";
            document.getElementById("clasificacion").value = data.clasificacion || "";
            document.getElementById("imagen").value = data.imagen || "";
            document.getElementById("enviar").innerHTML = "Eliminar";
            document.getElementById("enviar").classList.remove('btn-primary');
            document.getElementById("enviar").classList.add('btn-danger');

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