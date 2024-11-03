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

require_once("../models/conexion.php");
include("../models/ClienteJuridicoModel.php");
include("../models/ClasificacionModel.php");

// Obtener las clasificaciones existentes para el select
$clasificaciones = ClasificacionModel::listar();
?>

<!DOCTYPE html>
<html lang="en">
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
                    <form action="../controladores/ControladorClienteJuridico.php" method="POST" class="row" name="form">
                        <input type="hidden" name="action" value="insert">
                        
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
                                <input type="text" class="form-control" id="telefono" name="telefono" maxlength="15" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="representante_legal">Representante Legal</label>
                                <input type="text" class="form-control" id="representante_legal" name="representante_legal" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="aval">Aval</label>
                                <input type="text" class="form-control" id="aval" name="aval">
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
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Agregar Cliente Jurídico</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layouts/footerScript.php'; ?>

    <script>
        function Solo_Texto(e) {
            var code;
            if (!e) var e = window.event;
            if (e.keyCode) code = e.keyCode;
            else if (e.which) code = e.which;
            var character = String.fromCharCode(code);
            var AllowRegex = /^[\ba-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/;
            if (AllowRegex.test(character)) return true;
            return false;
        }

        function validarFormulario() {
            const clasificacion_id = document.getElementById('clasificacion_id').value;
            if (clasificacion_id == '') {
                Swal.fire("Debe seleccionar una clasificación");
                return false; // Evitar el envío del formulario
            }
            return true;
        }
    </script>
</body>
</html>
