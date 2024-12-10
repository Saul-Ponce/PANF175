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

include "../controladores/ControladorCompra.php";
include_once "../models/CompraModel.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Lista de compras</title>
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
        <div class="container mt-4 ">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3 class="card-title text-center align-middle">Lista de compras</h3>
                    <table id="tabla-compra" class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <td class="font-weight: 700; font-size:10px; text-align: center!important;"
                                    scope="col">Fecha</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">Total</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">detalles</th>
                                <th style="font-weight: 700; font-size:10px; text-align: center!important; "
                                    scope="col">usuario</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultado = ControladorCompra::listar();
                            while ($row = mysqli_fetch_assoc($resultado)): ?>
                                  <tr data-compra-id="<?=$row['compras_id']?>">
                                    <td >
                                        <?= $row["fecha"] ?>
                                    </td>
                                    <td>
                                        $<?= $row["total_compra"] ?>
                                    </td>


                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="showDetalles(<?= $row['compras_id'] ?>)" data-bs-toggle="modal" data-bs-target="#mdverF">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <?= $row["nombre"] ?>
                                    </td>

                                </tr>



                            <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>








    <div class="modal modal-blur fade" id="detalleCompraModal" tabindex="-1" role="dialog" aria-labelledby="detalleCompraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleCompraModalLabel">Detalles de la Compra</h5>
                    <!-- Close button (X) -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>proveedor</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody id="detalleCompraTableBody">
                            <!-- Rows will be dynamically appended -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <!-- Cerrar button -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            $('#tabla-compra').DataTable({
                "language": {
                    "url": "./../public/assets/libs/datatables/esp.json"
                },
            });
        });

        function showDetalles(compraId) {
            $.ajax({
                url: '../vistas/getDetalleCompra.php', // The PHP file to fetch the details
                method: 'GET',
                data: {
                    id_compra: compraId
                }, // Send the compraId to fetch details
                success: function(response) {
                    try {
                        // Directly use the response since the server sends a valid JSON array
                        const detalle = response;

                        const tableBody = $('#detalleCompraTableBody');
                        tableBody.empty(); // Clear any previous rows

                        if (detalle.length === 0) {
                            tableBody.append('<tr><td colspan="4">No hay detalles disponibles.</td></tr>');
                            return;
                        }
                        // Store the compras_id in a global variable or directly in a hidden field
                        window.currentCompraId = compraId; // Store the compras_id globally

                        detalle.forEach(item => {
                            const row = `<tr id="row-${item.id}">
        <td>${item.nombre}</td>
         <td>${item.nombre_proveedor}</td>
        <td><input type="number" class="form-control" value="${item.cantidad}" id="cantidad-${item.id}" /></td>
        <td><input type="number" step="0.01" class="form-control" value="${item.precio_unitario}" id="precio-${item.id}" /></td>
        <td id="total-${item.id}">${(item.cantidad * item.precio_unitario).toFixed(2)}</td>
        <td>
            <button class="btn btn-success btn-sm" onclick="updateDetalle(${item.id})">Guardar</button>
        </td>
    </tr>`;
                            tableBody.append(row);
                        });




                        // Show the modal
                        $('#detalleCompraModal').modal('show');
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        alert('Error al procesar los datos del servidor.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Error en la solicitud al servidor.');
                }
            });
        }

        function updateDetalle(id) {
    const cantidad = $(`#cantidad-${id}`).val();
    const precio_unitario = $(`#precio-${id}`).val();

    $.ajax({
        url: '../controladores/ControladorCompra.php?action=updateDetalleCompra',
        method: 'POST',
        data: {
            action: "updateDetalleCompra",
            id: id,
            cantidad: cantidad,
            precio_unitario: precio_unitario
        },
        success: function(response) {
            try {
                const result = JSON.parse(response);
                if (result.success) {
                    Swal.fire('Actualizado!', 'Se ha editado correctamente.', 'success');
                    // Update the total in the table row
                    const newTotal = (cantidad * precio_unitario).toFixed(2);
                    $(`#total-${id}`).text(`$${newTotal}`);

                    // Update the total compra amount
                    let totalCompra = 0;
                    $('#detalleCompraTableBody tr').each(function() {
                        const rowTotal = parseFloat($(this).find('td').eq(3).text().replace('$', ''));
                        if (!isNaN(rowTotal)) {
                            totalCompra += rowTotal;
                        }
                    });
                    updateCompraTotal(currentCompraId, totalCompra);

                } else {
                    Swal.fire('Error!', result.message || 'No se pudo actualizar el detalle.', 'error');
                }
            } catch (e) {
                console.error('Error parsing response:', e);
                Swal.fire('Error!', 'Ocurrió un problema con el servidor.', 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            Swal.fire('Error!', 'Ocurrió un problema con la solicitud.', 'error');
        }
    });
}

        function updateCompraTotal(compraId, totalCompra) {
            $.ajax({
                url: '../controladores/ControladorCompra.php?action=updateTotalCompra',
                method: 'POST',
                data: {
                    action: "updateTotalCompra",
                    compra_id: compraId,
                    total_compra: totalCompra.toFixed(2)
                },
                success: function(response) {
                    try {
                        const result = JSON.parse(response);
                        if (result.success) {
                            const row = $(`#tabla-compra tr[data-compra-id=${compraId}]`);
                    row.find('td:nth-child(2)').text(`$${totalCompra.toFixed(2)}`);


                        } else {
                            Swal.fire('Error!', 'No se pudo actualizar el total de la compra.', 'error');
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        Swal.fire('Error!', 'Ocurrió un problema con el servidor.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire('Error!', 'Ocurrió un problema con la solicitud.', 'error');
                }
            });
        }




       
    </script>
</body>

</html>