<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || 
    ($_SESSION['rol'] != "Administrador" && $_SESSION['rol'] != "Vendedor")) {
    echo '
    <script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html"
    </script>';
    session_destroy();
    die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Gestión de Embargos</title>
    <meta content="Proyecto de análisis financiero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>

    <div class="main-panel">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center" style="font-weight: 700;">Gestión de Embargos</h3>
                    <div class="table-responsive">
                        <table id="tabla-embargos" class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>ID Embargo</th>
                                    <th>Cliente</th>
                                    <th>Monto</th>
                                    <th>Saldo</th>
                                    <th>Fecha de Embargo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los datos serán cargados dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layouts/footerScript.php'; ?>

    <script>
        $(document).ready(function () {
            cargarEmbargos();
        });

        function cargarEmbargos() {
            $.ajax({
                url: '../controladores/ControladorEmbargo.php',
                type: 'POST',
                data: { action: 'listar' },
                dataType: 'json',
                success: function (response) {
                    if (!response.error) {
                        let tbody = '';
                        response.data.forEach(function (embargo) {
                            tbody += `<tr>
                                <td>${embargo.embargo_id}</td>
                                <td>${embargo.cliente}</td>
                                <td>$${parseFloat(embargo.monto).toFixed(2)}</td>
                                <td>$${parseFloat(embargo.saldo).toFixed(2)}</td>
                                <td>${embargo.fecha_embargo}</td>
                                <td>${embargo.estado === 'activo' ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Resuelto</span>'}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm me-2" onclick="resolverEmbargo(${embargo.embargo_id})">
                                        Resolver
                                    </button>
                                </td>
                            </tr>`;
                        });
                        $('#tabla-embargos tbody').html(tbody);
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo cargar la lista de embargos.', 'error');
                }
            });
        }

        function resolverEmbargo(embargoId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas marcar este embargo como resuelto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, resolver'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../controladores/ControladorEmbargo.php',
                        type: 'POST',
                        data: { action: 'cambiarEstado', embargo_id: embargoId, nuevo_estado: 'resuelto' },
                        dataType: 'json',
                        success: function (response) {
                            if (!response.error) {
                                Swal.fire('Resuelto', response.message, 'success');
                                cargarEmbargos();
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'No se pudo cambiar el estado del embargo.', 'error');
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>