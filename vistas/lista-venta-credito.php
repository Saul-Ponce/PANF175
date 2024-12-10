<?php
// vistas/lista-venta-credito.php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || 
   ($_SESSION['rol'] != "Administrador" && $_SESSION['rol'] != "Vendedor")) {
    echo '
    <script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html"
    </script>
    ';
    session_destroy();
    die();
}
include "../controladores/ControladorVentaCredito.php";
include "../models/UsuarioModel.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Ventas al Crédito</title>
    <meta content="Proyecto de analisis financiero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Ventas al Crédito</h3>
                    <div class="table-responsive">
                        <table id="tabla-ventas-credito" class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th style="font-weight: 700; font-size:16px;" scope="col">ID</th>
                                    <th style="font-weight: 700; font-size:16px;" scope="col">Fecha</th>
                                    <th style="font-weight: 700; font-size:16px;" scope="col">Cliente</th>
                                    <th style="font-weight: 700; font-size:16px;" scope="col">Usuario</th>
                                    <th style="font-weight: 700; font-size:16px;" scope="col">Total</th>
                                    <th style="font-weight: 700; font-size:16px;" scope="col">Contrato</th>
                                    <th style="font-weight: 700; font-size:16px;" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (ControladorVentaCredito::listar() as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row["id"]) ?></td>
                                        <td><?= htmlspecialchars($row["fecha"]) ?></td>
                                        <td><?= htmlspecialchars($row["cliente_natural"] ? $row["cliente_natural"] : $row["cliente_juridico"]) ?></td>
                                        <td><?= htmlspecialchars($row["usuario"]) ?></td>
                                        <td>$<?= htmlspecialchars($row["total_venta"]) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#mdVerContratoCredito"
                                                onclick='verContratoCredito(<?= htmlspecialchars($row["id"]) ?>)'>
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-info me-2" data-toggle="tooltip"
                                                    data-bs-placement="top" title="Ver detalles" data-bs-toggle="modal"
                                                    data-bs-target="#mdVerDetVCredito"
                                                    onclick='verDetalleVentaCredito(<?= htmlspecialchars($row["id"]) ?>)'>
                                                    <i class="fa-solid fa-bars"></i>
                                                </button>
                                            </div>
                                        </td>
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
    <!-- END main-panel -->

    <!-- Modal para Ver Detalles de Venta al Crédito -->
    <div class="modal fade" id="mdVerDetVCredito" tabindex="-1" aria-labelledby="verDetVCreditoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de la Venta al Crédito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dataDetVCredito" class="table-responsive"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Contrato de Venta al Crédito -->
    <div class="modal fade" id="mdVerContratoCredito" tabindex="-1" aria-labelledby="verContratoCreditoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contrato de Venta al Crédito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="iframeContratoCredito" src="" width="100%" height="600px"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap 5 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>
    <script src="../public/assets/js/toast.js"></script>

    <script>
        $(document).ready(function () {
            $('#tabla-ventas-credito').DataTable({
                "language": {
                    "url": "./../public/assets/libs/datatables/esp.json"
                },
            });
        });

        // Mostrar mensaje de éxito
        <?php if (isset($_SESSION['success_messageC'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '<?php echo $_SESSION['success_messageC']; ?>',
                timer: 3000,
                timerProgressBar: true,
                willClose: () => {
                    // Opcional: Recargar la página o realizar alguna acción adicional
                }
            });
            <?php unset($_SESSION['success_messageC']); ?>
        <?php endif; ?>

        // Mostrar mensaje de error
        <?php if (isset($_SESSION['error_message'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $_SESSION['error_message']; ?>'
            });
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        // Función para ver detalles de la venta al crédito
let verDetalleVentaCredito = (id) => {
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
    };

    $.ajax({
        dataType: "json",
        method: "POST",
        url: "../controladores/ControladorVentaCredito.php",
        data: datos,
    }).done(function (json) {
        Swal.close();

        if (!json.error) {
            // Rellenar la tabla de detalles de productos
            document.getElementById("dataDetVCredito").innerHTML = json.detalles;

            // Rellenar la tabla de datos generales
            let dataGeneral = `
                <tr>
                    <td>${json.plazo}</td>
                    <td>${json.interes}%</td>
                    <td>$${json.total.toFixed(2)}</td>
                    <td>$${json.totalConIntereses.toFixed(2)}</td>
                </tr>
            `;
            document.getElementById("dataGeneralVCredito").innerHTML = dataGeneral;
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: json.message,
            });
        }
    }).fail(function () {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ocurrió un problema con la solicitud. Intenta nuevamente.",
        });
    });
};


        // Función para ver contrato de la venta al crédito
        let verContratoCredito = (id) => {
            Swal.fire({
                title: 'Procesando...',
                text: 'Por favor espera mientras procesamos tu solicitud',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let datos = {
                "action": "ver-contrato",
                "id": id
            }
            $.ajax({
                dataType: "json",
                method: "POST",
                url: "../controladores/ControladorVentaCredito.php",
                data: datos,
            }).done(function (json) {
                Swal.close();
                if (!json.error) {
                    document.getElementById("iframeContratoCredito").src = json.ruta_contrato;
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: json.message,
                    });
                }
            });
        }
    </script>

</body>

</html>
