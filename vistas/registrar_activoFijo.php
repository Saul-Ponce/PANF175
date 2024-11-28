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
$sql = "SELECT * FROM Catalogo_Tipos_Activos";
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
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Activo fijo</h3>
                </div>
                <div class="card-body">
                    <!-- Establece un ancho máximo para el formulario -->
                    <form action="../controladores/ControladorActivoFijo.php" method="POST"
                        name="form" onsubmit="return validarSeleccion()">
                        <input type="hidden" name="action" value="insert">
                        <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['id']; ?>">

                        <!-- Primera fila con 2 columnas -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="codigoUnidad">Código de la unidad</label>
                                <input type="text" class="form-control" id="codigoUnidad" name="codigoUnidad" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                        </div>
                        <!-- Segunda fila con 2 columnas -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="idTipoActivo">Tipo de activo fijo</label>
                                <select class="form-select" id="idTipoActivo" name="idTipoActivo">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($query as $row): ?>
                                        <option value="<?= $row["idTipoActivo"] ?>"><?= $row["nombreActivo"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="mensajeError" class="text-danger d-none" role="alert"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="fechaAdquisicion">Fecha de Adquisición</label>
                                <input type="date" class="form-control" name="fecha_adquisicion" max="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>

                        <!-- Tercera fila con 2 columnas -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="valorAdquisicion">Valor de Adquisición</label>
                                <input type="number" class="form-control" name="valor_adquisicion" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label for="vidaUtil">Vida Útil (años)</label>
                                <input type="number" class="form-control" name="vida_util" step="1" min="0" required>
                            </div>
                        </div>

                        <!-- Cuarta fila con solo un campo (Estado del Activo) que ocupará toda la fila -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="estadoActivo">Estado del Activo</label>
                                <select class="form-select" id="estadoActivo" name="estadoActivo" required>
                                    <option value="1">Nuevo</option>
                                    <option value="2">Usado</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_registro">Fecha de Registro</label>
                                <input type="date" class="form-control" name="fecha_registro" max="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <!-- Botón de guardar -->
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

        function validarSeleccion() {
            const tipoActivo = document.getElementById("idTipoActivo").value;
            const mensajeError = document.getElementById("mensajeError");
            const select = document.getElementById("idTipoActivo");

            if (tipoActivo === "0") {
                // Cambiar el borde del select a rojo
                select.classList.add("is-invalid");

                // Mostrar el mensaje de error
                mensajeError.textContent = "Por favor, seleccione un tipo de activo válido.";
                mensajeError.classList.remove("d-none"); // Muestra el mensaje de error

                return false; // Evita el envío del formulario
            }

            // Quitar el borde rojo si la validación pasa
            select.classList.remove("is-invalid");

            // Ocultar el mensaje de error
            mensajeError.classList.add("d-none");

            return true; // Permite el envío del formulario si la selección es válida
        }
    </script>
</body>

</html>