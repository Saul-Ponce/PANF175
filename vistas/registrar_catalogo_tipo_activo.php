<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['estado'] != 1 || $_SESSION['rol'] != "Administrador") {
    echo '
    <script>
        window.location = "../index.php"
    </script>
    ';
    session_destroy();
    die();
}
require_once "../models/conexion.php";
$con = connection();
$sql = "SELECT * FROM roles";
$query = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Usuarios</title>
    <meta content="Proyecto de analisis finaciero" name="description" />
    <meta content="Grupo ANF DIU" name="author" />
    <?php include '../layouts/headerStyles.php'; ?>
</head>

<body>
    <?php include '../layouts/Navbar.php'; ?>
    <div class="page-body">
        <div class="container d-flex justify-content-center"> <!-- Centramos el contenedor de la tarjeta -->
            <div class="card w-100" style="max-width: 400px;"> <!-- Limitamos el ancho de la tarjeta -->
                <div class="card-header">
                    <h3 class="card-title">Catálogo Tipos de Activo</h3>
                </div>
                <div class="card-body">
                    <!-- Establece un ancho máximo para el formulario -->
                    <form action="../controladores/ControladorCatalogoActivoFijo.php" method="POST" style="max-width: 500px; margin: auto;" name="form" onsubmit="return validarFormulariocompleto()">
                        <input type="hidden" name="action" value="insert">
                        <div class="mb-3">
                            <label for="codigo">Codigo</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombreActivo">Nombre</label>
                            <input type="text" class="form-control" id="nombreActivo" name="nombreActivo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="porcentajeDepreciacion">Porcentaje de Depreciación</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="porcentajeDepreciacion"
                                    name="porcentajeDepreciacion" step="0.01" min="0" required
                                    oninput="validarPorcentaje(this)">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include '../layouts/Footer.php'; ?>
    </div>
    <!-- Scripts de Bootstrap 4 y otros aquí -->
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

        function validarFormulariocompleto() {
            const nombre = document.getElementById('nombre').value;
            const descripcion = document.getElementById('descripcion').value;
            const porcentaje_depreciacion = document.getElementById('porcentaje_depreciacion').value;
            if (!nombre || !descripcion || !porcentaje_depreciacion) {
                Swal.fire("Aviso", "Por favor, complete todos los campos antes de enviar el formulario.", "warning");
                return false; // Evitar el envío del formulario
            }
            return true;
        }
    </script>
</body>

</html>