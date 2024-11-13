<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '<script>window.location = "../index.php"</script>';
    session_destroy();
    die();
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
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Correo Electrónico</th>
                                    <th>Representante Legal</th>
                                    <th>Clasificación</th>
                                    <th>Aval</th> <!-- Nueva columna para Aval -->
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = ControladorClienteJuridico::listar();
                                if ($resultado && mysqli_num_rows($resultado) > 0) {
                                    while ($row = mysqli_fetch_assoc($resultado)):
                                        // Crear una copia de $row sin el campo 'aval'
                                        $dataForJs = $row;
                                        $dataForJs['has_aval'] = !empty($row['aval']) ? true : false;
                                        unset($dataForJs['aval']);
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row["nombre"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["direccion"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["telefono"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td>
                                                <button class="btn btn-primary" onclick='verRepresentante(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' data-bs-toggle="modal" data-bs-target="#modalVerRepresentante">
                                                    Ver Representante
                                                </button>
                                            </td>
                                            <td>
                                                <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars($row["descripcion_clasificacion"], ENT_QUOTES, 'UTF-8') ?>">
                                                    <?= htmlspecialchars($row["nombre_clasificacion"], ENT_QUOTES, 'UTF-8') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (!empty($row["aval"])): ?>
                                                    <button class="btn btn-secondary" onclick='verAval(<?= (int)$row["id"] ?>)' data-bs-toggle="modal" data-bs-target="#modalVerAval">
                                                        Ver Aval
                                                    </button>
                                                <?php else: ?>
                                                    <span>No Disponible</span>
                                                <?php endif; ?>
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
                                                    <button type="button" class="btn btn-warning me-2" onclick='editarCliente(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' data-bs-toggle="modal" data-bs-target="#modalEditarCliente">
                                                        <i class="fa-regular fa-pen-to-square"></i> Editar
                                                    </button>
                                                    <button type="button" class="btn btn-info me-2" onclick='editarRepresentante(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' data-bs-toggle="modal" data-bs-target="#modalEditarRepresentante">
                                                        <i class="fa-regular fa-pen-to-square"></i> Editar Representante
                                                    </button>
                                                    <button type="button" class="btn <?= $row["estado"] === 'activo' ? 'btn-danger' : 'btn-success' ?>" onclick='cambiarEstado(<?= json_encode($dataForJs, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' data-bs-toggle="modal" data-bs-target="#modalCambiarEstado">
                                                        <?= $row["estado"] === 'activo' ? 'Marcar como Incobrable' : 'Activar' ?>
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

        <!-- Modal Ver Aval -->
        <div class="modal fade" id="modalVerAval" tabindex="-1" aria-labelledby="modalVerAvalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl"> <!-- Modal extra grande para la vista previa del PDF -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalVerAvalLabel" class="modal-title">Vista Previa del Aval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" onclick="cerrarVerAval()"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="modalVerAvalIframe" src="" width="100%" height="600px" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="cerrarVerAval()">Cerrar</button>
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
                return text.replace(/[&<>"']/g, function(m) { return map[m]; });
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

                // Verificar si el cliente tiene aval
                let verAvalButton = '';
                if (data.has_aval) {
                    verAvalButton = `
                        <div class="form-group mb-3">
                            <label>Aval Actual:</label>
                            <a href="vista_previa.php?id=${data.id}" target="_blank" class="btn btn-secondary">
                                Ver Aval
                            </a>
                        </div>
                    `;
                }

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
                    ${verAvalButton}
                    <div class="form-group mb-3">
                        <label for="aval">Cambiar Aval</label>
                        <input type="file" class="form-control" name="aval" accept=".pdf, .doc, .docx">
                        <small class="form-text text-muted">Dejar vacío si no desea cambiar el aval.</small>
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

            // Función para ver el Aval en un modal
            function verAval(id) {
                // Establecer la fuente del iframe para mostrar el PDF
                document.getElementById('modalVerAvalIframe').src = `vista_previa.php?id=${id}`;
            }

            // Función para cerrar el modal de Aval y limpiar el iframe
            function cerrarVerAval() {
                document.getElementById('modalVerAvalIframe').src = '';
            }

            // Inicializar tooltips de Bootstrap
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    </div>
</body>
</html>
