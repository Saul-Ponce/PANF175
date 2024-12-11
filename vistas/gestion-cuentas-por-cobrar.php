<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || ($_SESSION['rol'] != "Administrador" && $_SESSION['rol'] != "Vendedor")) {
    echo '<script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html"
    </script>';
    session_destroy();
    die();
}

include_once "../models/CuentasPorCobrarModel.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cuentas por Cobrar</title>
    <meta content="Proyecto de análisis financiero" name="description">
    <meta content="Grupo ANF DIU" name="author">
    <?php include '../layouts/headerStyles.php'; ?>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
</head>
<body>
    <?php include '../layouts/Navbar.php'; ?>

    <div class="main-panel">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3 class="card-title text-center fw-bold">Gestión de Cuentas por Cobrar</h3>
                    <table id="tablaCuentasPorCobrar" class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Venta ID</th>
                                <th>Tipo de Venta</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Saldo</th>
                                <th>Plazo de Cobro</th>
                                <th>Fecha de Vencimiento</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se llenarán dinámicamente con JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Registrar Pago -->
    <div class="modal fade" id="modalRegistrarPago" tabindex="-1" aria-labelledby="modalRegistrarPagoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formRegistrarPago">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegistrarPagoLabel">Registrar Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idCuenta" name="idCuenta">
                        <div class="mb-3">
                            <label for="montoPagado" class="form-label">Monto Pagado:</label>
                            <input type="number" class="form-control" id="montoPagado" name="montoPagado" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="interesPagado" class="form-label">Interés Pagado:</label>
                            <input type="number" class="form-control" id="interesPagado" name="interesPagado" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="capitalAbonado" class="form-label">Capital Abonado:</label>
                            <input type="number" class="form-control" id="capitalAbonado" name="capitalAbonado" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Marcar como Pagada -->
    <div class="modal fade" id="modalConfirmarPagada" tabindex="-1" aria-labelledby="modalConfirmarPagadaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formConfirmarPagada">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmarPagadaLabel">Confirmar Acción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idCuentaPagada" name="idCuentaPagada">
                        <p>¿Estás seguro de marcar esta cuenta como pagada?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Marcar como Pagada</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Historial de Pagos -->
    <div class="modal fade" id="modalVerHistorialPagos" tabindex="-1" aria-labelledby="modalVerHistorialPagosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerHistorialPagosLabel">Historial de Pagos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pago</th>
                                <th>Fecha de Pago</th>
                                <th>Monto Pagado</th>
                                <th>Interés Pagado</th>
                                <th>Capital Abonado</th>
                                <th>Saldo Restante</th>
                            </tr>
                        </thead>
                        <tbody id="tablaHistorialPagosModal">
                            <!-- Contenido generado dinámicamente por JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toastNotificacion" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastTitle">Notificación</strong>
                <small class="text-muted">Ahora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
            <div class="toast-body" id="toastBody">
                <!-- Mensaje -->
            </div>
        </div>
    </div>

    <?php include '../layouts/footerScript.php'; ?>
    <script>
        $(document).ready(function() {
            // Inicializar Bootstrap modales y toasts
            const registrarPagoModal = new bootstrap.Modal(document.getElementById('modalRegistrarPago'));
            const confirmarPagadaModal = new bootstrap.Modal(document.getElementById('modalConfirmarPagada'));
            const verHistorialPagosModal = new bootstrap.Modal(document.getElementById('modalVerHistorialPagos'));
            const toastElement = document.getElementById('toastNotificacion');
            const toast = new bootstrap.Toast(toastElement);

            function mostrarToast(titulo, mensaje, tipo='primary') {
                $('#toastTitle').text(titulo);
                $('#toastBody').text(mensaje);
                // Cambiar color según el tipo
                const toastHeader = $('#toastNotificacion .toast-header');
                toastHeader.removeClass('bg-primary bg-success bg-warning bg-danger text-white text-dark');
                switch(tipo){
                    case 'success':
                        toastHeader.addClass('bg-success text-white');
                        break;
                    case 'warning':
                        toastHeader.addClass('bg-warning text-dark');
                        break;
                    case 'danger':
                        toastHeader.addClass('bg-danger text-white');
                        break;
                    default:
                        toastHeader.addClass('bg-primary text-white');
                }
                toast.show();
            }

            // Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
              return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            // Cargar las cuentas por cobrar
            function cargarCuentasPorCobrar() {
                $.post('../controladores/ControladorCuentasPorCobrar.php', { action: 'listar' }, function(response) {
                    try {
                        const data = JSON.parse(response);
                        console.log(data); // Para depuración
                        if (!data.error) {
                            const cuentas = data.data;
                            const tbody = $('#tablaCuentasPorCobrar tbody');
                            tbody.empty();
                            if (cuentas.length === 0) {
                                tbody.append('<tr><td colspan="10">No hay datos disponibles</td></tr>');
                            } else {
                                cuentas.forEach(cuenta => {
                                    const tr = `
                                        <tr>
                                            <td>${cuenta.id}</td>
                                            <td>${cuenta.venta_id}</td>
                                            <td>${cuenta.tipo_venta}</td>
                                            <td>${cuenta.cliente}</td>
                                            <td>$${parseFloat(cuenta.monto).toFixed(2)}</td>
                                            <td>$${parseFloat(cuenta.saldo).toFixed(2)}</td>
                                            <td>${cuenta.plazo_cobro}</td>
                                            <td>${cuenta.fecha_vencimiento || 'N/A'}</td>
                                            <td>${cuenta.estado}</td>
                                            <td>
                                                <button class="btn btn-success btn-sm me-2" onclick="abrirModalRegistrarPago(${cuenta.id})" data-bs-toggle="tooltip" title="Registrar Pago"><i class="bi bi-cash-coin"></i></button>
                                                <button class="btn btn-warning btn-sm me-2" onclick="abrirModalConfirmarPagada(${cuenta.id})" data-bs-toggle="tooltip" title="Marcar como Pagada"><i class="bi bi-check-circle"></i></button>
                                                <button class="btn btn-info btn-sm" onclick="abrirModalVerHistorial(${cuenta.id})" data-bs-toggle="tooltip" title="Ver Historial de Pagos"><i class="bi bi-card-list"></i></button>
                                            </td>
                                        </tr>`;
                                    tbody.append(tr);
                                });
                                // Re-initialize tooltips after adding new elements
                                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                  return new bootstrap.Tooltip(tooltipTriggerEl)
                                })
                            }
                        } else {
                            mostrarToast('Error', data.message || 'Error al cargar las cuentas por cobrar.', 'danger');
                        }
                    } catch (error) {
                        console.error('Error al procesar la respuesta:', error);
                        mostrarToast('Error', 'Error al cargar los datos. Por favor, revisa la consola.', 'danger');
                    }
                });
            }

            cargarCuentasPorCobrar();

            // Abrir modal para registrar pago
            window.abrirModalRegistrarPago = function(idCuenta) {
                $('#idCuenta').val(idCuenta);
                $('#montoPagado').val('');
                $('#interesPagado').val('');
                $('#capitalAbonado').val('');
                registrarPagoModal.show();
            };

            // Abrir modal para confirmar marcar como pagada
            window.abrirModalConfirmarPagada = function(idCuenta) {
                $('#idCuentaPagada').val(idCuenta);
                confirmarPagadaModal.show();
            };

            // Abrir modal para ver historial de pagos
            window.abrirModalVerHistorial = function(idCuenta) {
                // Limpiar tabla de historial
                $('#tablaHistorialPagosModal').empty();
                // Cargar historial via AJAX
                $.post('../controladores/ControladorHistorialPagos.php', { action: 'obtenerHistorial', idCuenta: idCuenta }, function(response) {
                    try {
                        const data = JSON.parse(response);
                        console.log(data); // Para depuración
                        if (!data.error) {
                            const historial = data.data;
                            const tbody = $('#tablaHistorialPagosModal');
                            tbody.empty();
                            if (historial.length === 0) {
                                tbody.append('<tr><td colspan="6">No hay datos disponibles</td></tr>');
                            } else {
                                historial.forEach(pago => {
                                    const tr = `
                                        <tr>
                                            <td>${pago.id}</td>
                                            <td>${pago.fecha_pago}</td>
                                            <td>$${parseFloat(pago.monto_pagado).toFixed(2)}</td>
                                            <td>$${parseFloat(pago.interes_pagado).toFixed(2)}</td>
                                            <td>$${parseFloat(pago.capital_abonado).toFixed(2)}</td>
                                            <td>$${parseFloat(pago.saldo_restante).toFixed(2)}</td>
                                        </tr>`;
                                    tbody.append(tr);
                                });
                            }
                            verHistorialPagosModal.show();
                        } else {
                            mostrarToast('Error', data.message || 'Error al cargar el historial de pagos.', 'danger');
                        }
                    } catch (error) {
                        console.error('Error al procesar la respuesta:', error);
                        mostrarToast('Error', 'Error al cargar el historial de pagos. Por favor, revisa la consola.', 'danger');
                    }
                });
            };

            // Registrar un pago
            $('#formRegistrarPago').submit(function(event) {
                event.preventDefault();
                const formData = $(this).serialize() + '&action=registrarPago';
                $.post('../controladores/ControladorCuentasPorCobrar.php', formData, function(response) {
                    try {
                        const data = JSON.parse(response);
                        console.log(data); // Para depuración
                        if (!data.error) {
                            mostrarToast('Éxito', data.message, 'success');
                            registrarPagoModal.hide();
                            cargarCuentasPorCobrar();
                        } else {
                            mostrarToast('Error', data.message, 'danger');
                        }
                    } catch (error) {
                        console.error('Error al procesar la respuesta:', error);
                        mostrarToast('Error', 'Error al registrar el pago. Por favor, revisa la consola.', 'danger');
                    }
                });
            });

            // Confirmar marcar como pagada
            $('#formConfirmarPagada').submit(function(event) {
                event.preventDefault();
                const idCuenta = $('#idCuentaPagada').val();
                const dataToSend = { action: 'marcarComoPagada', idCuenta: idCuenta };
                $.post('../controladores/ControladorCuentasPorCobrar.php', dataToSend, function(response) {
                    try {
                        const data = JSON.parse(response);
                        console.log(data); // Para depuración
                        if (!data.error) {
                            mostrarToast('Éxito', data.message, 'success');
                            confirmarPagadaModal.hide();
                            cargarCuentasPorCobrar();
                        } else {
                            mostrarToast('Error', data.message, 'danger');
                        }
                    } catch (error) {
                        console.error('Error al procesar la respuesta:', error);
                        mostrarToast('Error', 'Error al marcar la cuenta como pagada. Por favor, revisa la consola.', 'danger');
                    }
                });
            });

        });
    </script>
</body>
</html>
