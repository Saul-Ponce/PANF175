<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
    if($_SESSION['rol'] != "Vendedor"){
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

include "../controladores/ControladorClienteJuridico.php";
include_once "../models/ClienteJuridicoModel.php";
include_once "../models/ClasificacionModel.php";

// Obtener clasificaciones para usarlas en JavaScript
$clasificacionesArray = [];
$clasificacionesResult = ClasificacionModel::listar();
if ($clasificacionesResult) {
    while ($clasificacion = mysqli_fetch_assoc($clasificacionesResult)) {
        $clasificacionesArray[] = $clasificacion;
    }
} else {
    // Manejar error en la obtención de clasificaciones
    $_SESSION['error_messageC'] = "Error al obtener clasificaciones: " . mysqli_error($con);
    header("Location: ../vistas/lista-clientesjuridicos.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Clientes Jurídicos</title>
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
                    <h3 class="card-title text-center align-middle" style="font-weight: 700;">Lista de Clientes Jurídicos</h3>

                    <!-- Mostrar mensajes de éxito y error -->
                    <?php if (isset($_SESSION['success_messageC'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['success_messageC'], ENT_QUOTES, 'UTF-8') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['success_messageC']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_messageC'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_SESSION['error_messageC'], ENT_QUOTES, 'UTF-8') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['error_messageC']); ?>
                    <?php endif; ?>

                    <div class="table-responsive">
                    <table id="tabla-clientesjuridicos" class="table table-bordered text-center align-middle datatable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Correo Electrónico</th>
                                    <th>NIT</th> <!-- Nueva columna NIT-->
                                    <th>NRC</th> <!-- Nueva columna NRC -->
                                    <th>Representante Legal</th>
                                    <th>Clasificación</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorClienteJuridico::listar();
                                if ($resultado && mysqli_num_rows($resultado) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultado)):
                                        // Crear una copia de $row
                                        $dataForJs = $row;
                                ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row["nombre"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["direccion"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["telefono"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["nit"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["nrc"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td>
                                                <button class="btn btn-primary" onclick='verRepresentante(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' data-bs-toggle="modal" data-bs-target="#modalVerRepresentante">
                                                    Ver Representante
                                                </button>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars($row["descripcion_clasificacion"], ENT_QUOTES, 'UTF-8') ?>">
                                                    <?= htmlspecialchars($row["nombre_clasificacion"], ENT_QUOTES, 'UTF-8') ?>
                                                </span>
                                            </td>

                                            <td>
                                                <?php if ($row["estado"] === "activo"): ?>
                                                    <span class="badge bg-success text-white">Activo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger text-white">Incobrable</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <!-- Botón Editar Cliente -->
                                                    <button type="button" class="btn btn-warning me-2"
                                                        data-toggle="tooltip" data-bs-placement="top" title="Editar Cliente"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditarCliente"

                                                        onclick='editarCliente(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>

                                                    <!-- Botón Editar Representante -->
                                                    <button type="button" class="btn btn-info me-2"
                                                        data-toggle="tooltip" data-bs-placement="top" title="Editar Representante Legal"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditarRepresentante"

                                                        onclick='editarRepresentante(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>

                                                    <!-- Botón Cambiar Estado -->
                                                    <button type="button" class="btn <?= $row["estado"] === 'activo' ? 'btn-danger' : 'btn-success' ?>"
                                                        data-bs-toggle="modal" data-bs-target="#modalCambiarEstado"
                                                        data-toggle="tooltip" data-bs-placement="top" title="<?= $row["estado"] === 'activo' ? 'Marcar como Incobrable' : 'Activar' ?>"
                                                        onclick='cambiarEstado(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                                        <!-- Ícono para "Marcar como Incobrable" o "Activar" -->
                                                        <?php if ($row["estado"] === 'activo'): ?>
                                                            <i class="fa-solid fa-ban"></i> <!-- Ícono "Marcar como Incobrable" -->
                                                        <?php else: ?>
                                                            <i class="fa-solid fa-check"></i> <!-- Ícono "Activar" -->
                                                        <?php endif; ?>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    endwhile;
                                } else {
                                    echo '<tr><td colspan="9">No se encontraron clientes jurídicos.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales -->
        <!-- Modal Ver Representante -->
        <div class="modal fade" id="modalVerRepresentante" tabindex="-1" aria-labelledby="modalVerRepresentanteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalVerRepresentanteLabel" class="modal-title">Datos del Representante Legal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalVerRepresentanteContent">
                        <!-- Aquí se cargarán los datos del representante legal -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Editar Cliente -->
        <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="modalEditarClienteLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Modal grande para acomodar más campos -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalEditarClienteLabel" class="modal-title">Editar Cliente Jurídico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../controladores/ControladorClienteJuridico.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" id="cliente_id">
                        <div class="modal-body" id="modalEditarClienteContent">
                            <!-- Campos del cliente jurídico serán insertados aquí por JavaScript -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Representante -->
        <div class="modal fade" id="modalEditarRepresentante" tabindex="-1" aria-labelledby="modalEditarRepresentanteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalEditarRepresentanteLabel" class="modal-title">Editar Representante Legal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../controladores/ControladorClienteJuridico.php" method="POST">
                        <input type="hidden" name="action" value="editRepresentante">
                        <input type="hidden" name="representante_legal_id" id="representante_legal_id">
                        <div class="modal-body" id="modalEditarRepresentanteContent">
                            <!-- Campos del representante legal serán insertados aquí por JavaScript -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Cambiar Estado -->
        <div class="modal fade" id="modalCambiarEstado" tabindex="-1" aria-labelledby="modalCambiarEstadoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalCambiarEstadoLabel" class="modal-title">Cambiar Estado del Cliente Jurídico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../controladores/ControladorClienteJuridico.php" method="POST">
                        <input type="hidden" name="action" value="cambiarEstado">
                        <input type="hidden" name="id" id="estado_cliente_id">
                        <input type="hidden" name="estado" id="estado_cliente_estado">
                        <div class="modal-body" id="modalCambiarEstadoContent">
                            <!-- Mensaje de confirmación será insertado aquí por JavaScript -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="modalCambiarEstadoSubmitButton" class="btn">
                                <!-- Texto y clase del botón se cambiarán dinámicamente -->
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include '../layouts/footerScript.php'; ?>

        <script>
            const clasificaciones = <?php echo json_encode($clasificacionesArray, JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

            // Función para escapar HTML y prevenir XSS
            function escapeHtml(text) {
                var map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) {
                    return map[m];
                });
            }

            // Función para ver el representante legal
            function verRepresentante(data) {
                document.getElementById('modalVerRepresentanteLabel').innerText = 'Datos del Representante Legal';

                // Verificar que los datos existan antes de insertarlos
                let nombre = data.nombre_representante ? escapeHtml(data.nombre_representante) : 'N/A';
                let direccion = data.direccion_representante ? escapeHtml(data.direccion_representante) : 'N/A';
                let telefono = data.telefono_representante ? escapeHtml(data.telefono_representante) : 'N/A';
                let email = data.email_representante ? escapeHtml(data.email_representante) : 'N/A';
                let dui = data.dui_representante ? escapeHtml(data.dui_representante) : 'N/A';

                let modalContent = `
                    <p><strong>Nombre:</strong> ${nombre}</p>
                    <p><strong>Dirección:</strong> ${direccion}</p>
                    <p><strong>Teléfono:</strong> ${telefono}</p>
                    <p><strong>Correo Electrónico:</strong> ${email}</p>
                    <p><strong>DUI:</strong> ${dui}</p>
                `;
                document.getElementById('modalVerRepresentanteContent').innerHTML = modalContent;
            }

            // Función para editar el cliente jurídico
            function editarCliente(data) {
                document.getElementById('modalEditarClienteLabel').innerText = 'Editar Cliente Jurídico';
                document.getElementById('cliente_id').value = data.id;

                // Generar las opciones del select de clasificación
                let clasificacionOptions = '<option value="" disabled>Seleccione una clasificación</option>';
                clasificaciones.forEach(clasificacion => {
                    const selected = data.clasificacion_id == clasificacion.id ? 'selected' : '';
                    clasificacionOptions += `<option value="${clasificacion.id}" ${selected}>${escapeHtml(clasificacion.nombre)}</option>`;
                });

                // Cargar los campos en el modal
                let modalContent = `
        <div class="form-group mb-3">
            <label for="nombre">Nombre de la Empresa</label>
            <input type="text" class="form-control" name="nombre" value="${escapeHtml(data.nombre)}" required>
        </div>
        <div class="form-group mb-3">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" name="direccion" value="${escapeHtml(data.direccion)}" required>
        </div>
        <div class="form-group mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" name="telefono" value="${escapeHtml(data.telefono)}" maxlength="9" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" name="email" value="${escapeHtml(data.email)}" required>
        </div>
        <div class="form-group mb-3">
            <label for="nit">NIT</label>
            <input type="text" class="form-control" name="nit" value="${escapeHtml(data.nit)}" maxlength="17" placeholder="0000-000000-000-0" required>
        </div>
        <div class="form-group mb-3">
            <label for="nrc">NRC</label>
            <input type="text" class="form-control" name="nrc" value="${escapeHtml(data.nrc)}" maxlength="8" placeholder="000000-0" required>
        </div>
        <div class="form-group mb-3">
            <label for="clasificacion_id">Clasificación</label>
            <select class="form-select" name="clasificacion_id" required>
                ${clasificacionOptions}
            </select>
        </div>
    `;
                document.getElementById('modalEditarClienteContent').innerHTML = modalContent;
            }


            // Función para editar el representante legal
            function editarRepresentante(data) {
                document.getElementById('modalEditarRepresentanteLabel').innerText = 'Editar Representante Legal';
                document.getElementById('representante_legal_id').value = data.representante_legal;

                let modalContent = `
                    <div class="form-group mb-3">
                        <label for="nombre_representante">Nombre</label>
                        <input type="text" class="form-control" name="nombre_representante" value="${escapeHtml(data.nombre_representante)}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="direccion_representante">Dirección</label>
                        <input type="text" class="form-control" name="direccion_representante" value="${escapeHtml(data.direccion_representante)}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="telefono_representante">Teléfono</label>
                        <input type="text" class="form-control" name="telefono_representante" value="${escapeHtml(data.telefono_representante)}" maxlength="9" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email_representante">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email_representante" value="${escapeHtml(data.email_representante)}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="dui_representante">DUI</label>
                        <input type="text" class="form-control" name="dui_representante" value="${escapeHtml(data.dui_representante)}" maxlength="10" required>
                    </div>
                `;
                document.getElementById('modalEditarRepresentanteContent').innerHTML = modalContent;
            }

            // Función para cambiar el estado del cliente jurídico
            function cambiarEstado(data) {
                document.getElementById('modalCambiarEstadoLabel').innerText = 'Cambiar Estado del Cliente Jurídico';

                // Establecer los valores en los inputs ocultos
                document.getElementById('estado_cliente_id').value = data.id;
                document.getElementById('estado_cliente_estado').value = data.estado;

                // Generar el mensaje de confirmación
                let mensaje = data.estado === 'activo' ? '¿Está seguro de que desea marcar como Incobrable a este cliente?' : '¿Está seguro de que desea activar a este cliente?';
                document.getElementById('modalCambiarEstadoContent').innerHTML = `<p>${mensaje}</p>`;

                // Cambiar el texto y la clase del botón de submit
                let boton = document.getElementById('modalCambiarEstadoSubmitButton');
                boton.innerText = data.estado === 'activo' ? 'Marcar como Incobrable' : 'Activar';
                boton.className = data.estado === 'activo' ? 'btn btn-danger' : 'btn btn-success';
            }


            // Inicializar tooltips de Bootstrap
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });

            //Data table
            $(document).ready(function () {
        $('#tabla-clientesjuridicos').DataTable({
            "language": {
                "url": "./../public/assets/libs/datatables/esp.json"
            }
        });
    });
        </script>
    </div>
</body>

</html>