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

require_once "../models/conexion.php";
$con = connection();
$sql = "SELECT * FROM fiadores";
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
                    <h3 class="card-title">Agregar cliente natural</h3>
                </div>
                <div class="card-body">
                    <form action="../controladores/ControladorClienteNatural.php" method="POST" class="row" name="form"
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
                                <label for="direccion">Direccion</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    onkeypress="return Solo_Texto(event);">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono">telefono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ingresos">Ingresos</label>
                                <input type="text" class="form-control" id="ingresos" name="ingresos">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="egresos">egresos</label>
                                <input type="text" class="form-control" id="egresos" name="egresos">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="estado_civil">Estado civil</label>
                                <select class="form-select" id="estado_civil" name="estado_civil">
                                    <option value="0">Seleccione</option>
                                    <option value="soltero">Soltero</option>
                                    <option value="casado">Casado</option>
                                    <option value="viudo">Viudo</option>
                                    <option value="separado">Separado</option>
                                    <option value="divorciado">Divorciado</option>
                                
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lugar">Lugar de trabajo</label>
                                <input type="text" class="form-control" id="lugar_trabajo" name="lugar_trabajo"
                                    onkeypress="return Solo_Texto(event);">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dui">DUI</label>
                                <input type="text" class="form-control" id="dui" name="dui">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fiador_id">Fiador</label>
                                <select class="form-select" id="fiador_id" name="fiador_id">
                                    <option value="0">Seleccione</option>
                                    <?php foreach ($query as $row): ?>
                                    <option value="<?=$row["id"]?>"> <?=$row["nombre"]?> <?="-"?> <?=$row["dui"]?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>



                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Agregar cliente</button>
                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>
    </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->
    <?php include '../layouts/footerScript.php'; ?>


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