<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
    if ($_SESSION['rol'] != "Vendedor") {
        echo '
        <script>
            alert("Por favor Inicia Sesion");
            window.location = "../index.html"
        </script>
        ';
        session_destroy();
        die();
    }
}
include "../controladores/ControladorVentaContado.php";
include "../models/UsuarioModel.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Ventas al contado</title>
        <meta content="Proyecto de analisis finaciero" name="description" />
        <meta content="Grupo ANF DIU" name="author" />
        <?php include '../layouts/headerStyles.php'; ?>
    </head>

</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./../public/assets/libs/datatables/datatables.min.js"></script>

    <div class="main-panel">
        <div class="container mt-4 ">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Ventas</h3>
                    <div class="table-responsive">
                        <table id="tabla-ventas" class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-weight: 700; font-size:16px; text-align: center!important;"
                                        scope="col">
                                        ID</th>
                                    <th style="font-weight: 700; font-size:16px; text-align: center!important;"
                                        scope="col">
                                        Fecha</th>
                                    <th style="font-weight: 700; font-size:16px; text-align: center!important;"
                                        scope="col">
                                        Cliente</th>
                                    <th style="font-weight: 700; font-size:16px; text-align: center!important;"
                                        scope="col">
                                        Usuario</th>
                                    <th style="font-weight: 700; font-size:16px; text-align: center!important;"
                                        scope="col">
                                        Total</th>
                                    <th style="font-weight: 700; font-size:16px; text-align: center!important;"
                                        scope="col">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (ControladorVentaContado::listar() as $row): ?>
                                    <tr>
                                        <td><?= $row["id"] ?></td>
                                        <td><?= $row["fecha"] ?></td>
                                        <td><?= $row["cnatural"] ? $row["cnatural"] : $row["cjurdico"] ?></td>
                                        <td><?= $row["usuario"] ?> </td>
                                        <td>$<?= $row["total_venta"] ?></td>
                                        <th>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-info me-2" data-toggle="tooltip"
                                                    data-bs-placement="top" title="Ver detalles" data-bs-toggle="modal"
                                                    data-bs-target="#mdverDetVCont"
                                                    onclick='verDetalleVentaCont(<?= json_encode($row["id"]) ?>)'><i
                                                        class="fa-solid fa-bars"></i></button>
                                                <button type="button" class="btn btn-warning me-2" data-toggle="tooltip"
                                                    data-bs-placement="top" title="Generar nota de credito"
                                                    data-bs-toggle="modal" data-bs-target="#mdNotaCredito"><i
                                                        class="fa-solid fa-rotate-left"></i></button>
                                                <form method="POST" action="../includes/Facturas/invoicecontado.php"
                                                    target="_blank">
                                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                    <button type="submit" class="btn btn-info me-2" data-toggle="tooltip"
                                                        data-bs-placement="top" title="Generar Factura"
                                                        data-bs-toggle="modal"><i
                                                            class="fa-solid fa-file-lines"></i></button>
                                                </form>
                                            </div>
                                        </th>
                                    </tr>

                                <?php endforeach; ?>

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

    <?php include '../vistas/Modals/ModalVerDetVCont.php'; ?>
    <?php include '../vistas/Modals/ModalNotaCredito.php'; ?>
    <script src="../public/assets/js/toast.js"></script>

    <script>
        function factura(id) {
            // Dimensiones de la nueva ventana
            const width = 800;
            const height = 600;

            // Calcular posición para centrar la ventana
            const screenWidth = window.screen.width;
            const screenHeight = window.screen.height;

            const left = (screenWidth - width) / 2;
            const top = (screenHeight - height) / 2;

            // Abrir ventana centrada
            window.open(
                '../includes/Facturas/invoicecontado.php',
                '_blank',
                `width=${width},height=${height},scrollbars=yes,left=${left},top=${top}`
            );
        }
        $(document).ready(function () {
            $('#tabla-ventas').DataTable({
                "language": {
                    "url": "./../public/assets/libs/datatables/esp.json"
                },
            });
        });
        // Inicializar tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        // Check if a success message is set in the session
        <?php if (isset($_SESSION['success_messageC'])): ?>
            Swal.fire('<?php echo $_SESSION['success_messageC']; ?>', '', 'success');
            <?php unset($_SESSION['success_messageC']); // Clear the message ?>
        <?php endif; ?>

        let verDetalleVentaCont = (id) => {
            Swal.fire({
                title: 'Procesando...',
                text: 'Por favor espera mientras procesamos tu solicitud',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let datos = {
                "action": "ver-det",
                "id": id
            }
            $.ajax({
                dataType: "json",
                method: "POST",
                url: "../controladores/ControladorVentaContado.php",
                data: datos,
            }).done(function (json) {
                swal.close();
                document.getElementById("dataDV").innerHTML = json
                /* if (json.exito) {
                    
                } else {
                    Swal.fire({
                        icon: "error",
                        title: json[1],
                        text: json.error,
                    });
                } */
            });
        }
    </script>

</body>

</html>