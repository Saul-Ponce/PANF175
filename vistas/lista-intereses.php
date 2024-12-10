<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
    echo '
    <script>
        alert("Por favor Inicia Sesión");
        window.location = "../index.html";
    </script>';
    session_destroy();
    die();
}

include "../controladores/ControladorIntereses.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Lista de Intereses</title>
    <?php include '../layouts/headerStyles.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="./../public/assets/libs/datatables/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Ajustar encabezados de la tabla */
        #tabla-intereses th {
            text-align: center; /* Centrar texto */
            font-size: 1.2rem; /* Tamaño de letra más grande */
            vertical-align: middle; /* Centrar verticalmente */
        }

        /* Reducir el padding de las celdas */
        #tabla-intereses td {
            text-align: center; /* Centrar texto */
            padding: 8px; /* Reducir espacios verticales */
            font-size: 1rem; /* Aumentar ligeramente el tamaño del texto */
        }

        /* Hacer la tabla más compacta */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 10px 0; /* Reducir espacios entre los elementos */
        }
          /* Ajustar ancho de las columnas específicas */
    #tabla-intereses th:nth-child(2), /* Columna PLAZO (MESES) */
    #tabla-intereses td:nth-child(2) {
        width: 10%; /* Ajusta el ancho según lo necesario */
    }

    #tabla-intereses th:nth-child(3), /* Columna TASA DE INTERÉS (%) */
    #tabla-intereses td:nth-child(3) {
        width: 12%; /* Ajusta el ancho según lo necesario */
    }
    </style>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>

    <div class="main-panel">
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center" style="font-weight: 700;">Lista de Intereses</h3>

                    <!-- Mensajes de éxito y error -->
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <!-- Botón para agregar nuevo interés -->
                    <div class="mb-3 text-end">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarInteres">
                            Agregar Interés
                        </button>
                    </div>

                    <!-- Tabla de intereses -->
                    <div class="table-responsive">
                        <table id="tabla-intereses" class="table table-bordered text-center align-middle datatable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Plazo (Meses)</th>
                                    <th>Tasa de Interés (%)</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorIntereses::listar();
                                if ($resultado && mysqli_num_rows($resultado) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultado)):
                                        $dataForJs = $row;
                                ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row["nombre"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["plazo_meses"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["tasa_interes"], ENT_QUOTES, 'UTF-8') ?>%</td>
                                            <td><?= htmlspecialchars($row["descripcion"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <!-- Botón Editar -->
                                                    <button class="btn btn-warning me-2"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditarInteres"
                                                        onclick='editarInteres(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                                        Editar
                                                    </button>
                                                    <!-- Botón Borrar -->
                                                    <button class="btn btn-danger"
                                                        data-bs-toggle="modal" data-bs-target="#modalBorrarInteres"
                                                        onclick='borrarInteres(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                                        Borrar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    endwhile;
                                } else {
                                    echo '<tr><td colspan="5">No se encontraron intereses registrados.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Agregar Interés -->
        <div class="modal fade" id="modalAgregarInteres" tabindex="-1" aria-labelledby="modalAgregarInteresLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../controladores/ControladorIntereses.php" method="POST">
                        <input type="hidden" name="action" value="insert">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAgregarInteresLabel">Agregar Interés</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="plazo_meses">Plazo (Meses)</label>
                                <input type="number" class="form-control" name="plazo_meses" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tasa_interes">Tasa de Interés (%)</label>
                                <input type="number" step="0.01" class="form-control" name="tasa_interes" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Interés -->
        <div class="modal fade" id="modalEditarInteres" tabindex="-1" aria-labelledby="modalEditarInteresLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../controladores/ControladorIntereses.php" method="POST">
                        <input type="hidden" name="action" value="editar">
                        <input type="hidden" name="id" id="editar_id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarInteresLabel">Editar Interés</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="editar_nombre" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="plazo_meses">Plazo (Meses)</label>
                                <input type="number" class="form-control" name="plazo_meses" id="editar_plazo_meses" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tasa_interes">Tasa de Interés (%)</label>
                                <input type="number" step="0.01" class="form-control" name="tasa_interes" id="editar_tasa_interes" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" name="descripcion" id="editar_descripcion" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Borrar Interés -->
        <div class="modal fade" id="modalBorrarInteres" tabindex="-1" aria-labelledby="modalBorrarInteresLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="../controladores/ControladorIntereses.php" method="POST">
                        <input type="hidden" name="action" value="borrar">
                        <input type="hidden" name="id" id="borrar_id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalBorrarInteresLabel">Borrar Interés</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>¿Está seguro de que desea borrar este interés?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Borrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layouts/footerScript.php'; ?>

    <script>
        $(document).ready(function () {
    $('#tabla-intereses').DataTable({
        "language": {
            "url": "./../public/assets/libs/datatables/esp.json"
        },
        "dom": '<"top"lf>t<"bottom"ip><"clear">', // Compactar el diseño
        "paging": true,
        "searching": true,
        "info": true,
        "lengthChange": true,
        "pageLength": 10,
        "order": [[1, "asc"]],
        "autoWidth": false // Desactiva el autoajuste de ancho
    });
});

        function editarInteres(data) {
            document.getElementById('editar_id').value = data.id;
            document.getElementById('editar_nombre').value = data.nombre;
            document.getElementById('editar_plazo_meses').value = data.plazo_meses;
            document.getElementById('editar_tasa_interes').value = data.tasa_interes;
            document.getElementById('editar_descripcion').value = data.descripcion;
        }

        function borrarInteres(data) {
            document.getElementById('borrar_id').value = data.id;
        }
    </script>
</body>
</html>
