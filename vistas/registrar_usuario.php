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
    <?php include '../layouts/headerStyles.php';?>
</head>

<body>
    <?php include '../layouts/Navbar.php';?>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Agregar usuarios</h3>
                </div>
                <div class="card-body">
                    <form action="../controladores/ControladorUsuario.php" method="POST" class="row" name="form"
                        onsubmit="return validarFormulariocompleto()">
                        <input type="hidden" name="action" value="insert">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    onkeypress="return Solo_Texto(event);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="usuario">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario"
                                    onkeypress="return Solo_Texto(event);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rol">Rol</label>
                                <select class="form-select" id="rol_id" name="rol_id">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($query as $row): ?>
                                    <option value="<?=$row["id"]?>"><?=$row["nombre"]?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contrasena">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="correo_recuperacion">Correo de recuperacion</label>
                                <input type="email" class="form-control" id="correo_recuperacion"
                                    name="correo_recuperacion">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Agregar Usuario</button>
                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>
    <?php include '../layouts/Footer.php';?>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php';?>


    <script>
    function validarFormulario() {
        var rol = document.getElementById('rol').value;
        if (rol == 0) {
            Swal.fire("Debe seleccionar un rol");
            return false; // Evitar el envío del formulario
        }
        return true;
    }

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
        const usuario = document.getElementById('apellido').value;
        const rol = document.getElementById('rol_id').value;
        const contrasena = document.getElementById('contrasena').value;


        if (!nombre || !usuario || rol === '0' || !contrasena) {
            Swal.fire("Aviso", "Por favor, complete todos los campos antes de enviar el formulario.", "warning");
            return false; // Evitar el envío del formulario
        }

        return true;

    }
    </script>
</body>

</html>