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

include_once "../models/HistorialPagosModel.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Historial de Pagos</title>
    <meta content="Historial de Pagos de Clientes" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>

    <div class="main-panel">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body table-responsive">
                    <h3 class="card-title text-center fw-bold">Historial de Pagos</h3>
                    <table class="table table-bordered text-center align-middle" id="tablaHistorialPagos">
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
                        <tbody>
                            <!-- Contenido generado dinámicamente por JavaScript -->
                        </tbody>
                    </table>
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
    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastElement = document.getElementById('toastNotificacion');
            const toast = new bootstrap.Toast(toastElement);

            function mostrarToast(titulo, mensaje, tipo='primary') {
                document.getElementById('toastTitle').innerText = titulo;
                document.getElementById('toastBody').innerText = mensaje;
                const toastHeader = document.querySelector('#toastNotificacion .toast-header');
                toastHeader.className = 'toast-header';
                switch(tipo){
                    case 'success':
                        toastHeader.classList.add('bg-success', 'text-white');
                        break;
                    case 'warning':
                        toastHeader.classList.add('bg-warning', 'text-dark');
                        break;
                    case 'danger':
                        toastHeader.classList.add('bg-danger', 'text-white');
                        break;
                    default:
                        toastHeader.classList.add('bg-primary', 'text-white');
                }
                toast.show();
            }

            // Obtener el ID de la cuenta desde la URL
            function getQueryParameter(param) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            const idCuenta = getQueryParameter('idCuenta');

            if (idCuenta) {
                fetchHistorialPagos(idCuenta);
            } else {
                mostrarToast('Error', 'No se ha especificado el ID de la cuenta.', 'danger');
            }

            function fetchHistorialPagos(idCuenta) {
                fetch('../controladores/ControladorHistorialPagos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'obtenerHistorial',
                        idCuenta: idCuenta
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Para depuración
                    if (data.error) {
                        mostrarToast('Error', data.message || 'Error al cargar el historial.', 'danger');
                    } else {
                        populateHistorialTable(data.data || []);
                    }
                })
                .catch(error => {
                    console.error('Error fetching historial de pagos:', error);
                    mostrarToast('Error', 'Error al cargar los datos del historial.', 'danger');
                });
            }

            function populateHistorialTable(historial) {
                const tbody = document.querySelector('#tablaHistorialPagos tbody');
                tbody.innerHTML = '';

                if (historial.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6">No hay datos disponibles</td></tr>';
                } else {
                    historial.forEach(pago => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${pago.id}</td>
                            <td>${pago.fecha_pago}</td>
                            <td>$${parseFloat(pago.monto_pagado).toFixed(2)}</td>
                            <td>$${parseFloat(pago.interes_pagado).toFixed(2)}</td>
                            <td>$${parseFloat(pago.capital_abonado).toFixed(2)}</td>
                            <td>$${parseFloat(pago.saldo_restante).toFixed(2)}</td>`;
                        tbody.appendChild(row);
                    });
                }
            }
        });
    </script>
</body>

</html>
