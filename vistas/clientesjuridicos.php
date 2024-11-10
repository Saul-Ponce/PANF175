<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '<script>window.location = "../index.php"</script>';
    session_destroy();
    die();
}

require_once("../models/conexion.php");
include("../models/ClasificacionModel.php");

// Obtener las clasificaciones existentes para el select
$clasificaciones = ClasificacionModel::listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente Jurídico</title>
    <?php include '../layouts/headerStyles.php'; ?>
</head>
<body>
    <?php include '../layouts/Navbar.php'; ?>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Agregar Cliente Jurídico</h3>
                </div>
                <div class="card-body">
                    <!-- Inicio del formulario principal -->
                    <form action="../controladores/ControladorClienteJuridico.php" method="POST" class="row" name="form" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="insert">

                        <!-- Campos del cliente jurídico -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre">Nombre de la Empresa</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" maxlength="9" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <!-- Campo para cargar el archivo de aval -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="aval">Aval</label>
                                <input type="file" class="form-control" id="aval" name="aval" accept=".pdf, .doc, .docx">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="clasificacion_id">Clasificación</label>
                                <select class="form-select" id="clasificacion_id" name="clasificacion_id" required>
                                    <option value="" disabled selected>Seleccione una clasificación</option>
                                    <?php while ($clasificacion = mysqli_fetch_assoc($clasificaciones)) : ?>
                                        <option value="<?php echo $clasificacion['id']; ?>">
                                            <?php echo $clasificacion['nombre']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="estado">Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado" value="activo" readonly>
                            </div>
                        </div>

                        <!-- Botón para abrir el modal de agregar representante legal -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="representante_legal">Representante Legal</label>
                                <button type="button" class="btn btn-info form-control" data-bs-toggle="modal" data-bs-target="#modalRepresentanteLegal">
                                    Agregar Representante Legal
                                </button>
                            </div>
                        </div>

                        <!-- Modal para agregar representante legal (dentro del formulario) -->
                        <div class="modal fade" id="modalRepresentanteLegal" tabindex="-1" aria-labelledby="modalRepresentanteLegalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Agregar Representante Legal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Campos del representante legal -->
                                        <div class="mb-3">
                                            <label for="nombre_representante">Nombre</label>
                                            <input type="text" class="form-control" id="nombre_representante" name="nombre_representante" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="direccion_representante">Dirección</label>
                                            <input type="text" class="form-control" id="direccion_representante" name="direccion_representante" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telefono_representante">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono_representante" name="telefono_representante" maxlength="9" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email_representante">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="email_representante" name="email_representante" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dui_representante">DUI</label>
                                            <input type="text" class="form-control" id="dui_representante" name="dui_representante" maxlength="10" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Botón "Guardar" que cierra el modal -->
                                        <button type="button" class="btn btn-primary" onclick="closeModal()">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón para enviar el formulario -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Agregar Cliente Jurídico</button>
                        </div>
                    </form>
                    <!-- Fin del formulario principal -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../layouts/footerScript.php'; ?>

    <script>
        // Máscara para el campo de teléfono del cliente jurídico
        document.getElementById("telefono").addEventListener("input", function (e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 8);
            }
            this.value = value.slice(0, 9);
        });

        // Máscara para el campo de teléfono del representante legal
        document.getElementById("telefono_representante").addEventListener("input", function (e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 8);
            }
            this.value = value.slice(0, 9);
        });

        // Máscara para el campo de DUI del representante legal
        document.getElementById("dui_representante").addEventListener("input", function (e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 8) {
                value = value.slice(0, 8) + '-' + value.slice(8, 9);
            }
            this.value = value.slice(0, 10);
        });

        function closeModal() {
            // Validar los campos del representante legal antes de cerrar el modal (opcional)
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalRepresentanteLegal'));
            modal.hide();
        }
    </script>
</body>
</html>
