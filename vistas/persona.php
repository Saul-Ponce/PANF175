<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html"
    </script>
    ';
    session_destroy();
    die();
}

require_once "../models/conexion.php";
include "../models/PersonaModel.php";
$con = connection();
$sql = "SELECT * FROM rol";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--     Fonts and icons     -->

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />


    <!--   Core JS Files   -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="../assets/js/plugins/bootstrap-switch.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>

    <title>Empleado</title>
</head>

<body>
<?php
include '../includes/sidebar.php';
?>
    <div class="main-panel">
    <div class="container mt-5">
    <h3 class=" text-center align-middle font-weight-bold">Agregar empleados</h3>
        <form action="../controladores/ControladorPersona.php" method="POST" class="row" name="form"
           onsubmit="return validarFormulariocompleto()">
            <input type="hidden" name="action" value="insert">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dui">DUI</label>
                    <input type="text" class="form-control" id="dui" name="dui" maxlength="10"
                        pattern="^\d{8}-\d{1}$" title="Formato válido: 12345678-9" oninput="formatoDUI(this)" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"   onkeypress="return Solo_Texto(event);">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido"  onkeypress="return Solo_Texto(event);">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fechaNacimiento">Fecha de Nacimiento</label>
                    <?php
// Calcular la fecha de hace 18 años desde la fecha actual
$fechaMaxima = date('Y-m-d', strtotime('-18 years'));
echo '<input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" max="' . $fechaMaxima . '" onchange="calcularEdad(this.value)">';
?>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="form-control" id="rol" name="rol" >
                        <option value="0">Seleccione</option>
                        <?php foreach ($query as $row): ?>
                            <option value="<?=$row["id_rol"]?>"><?=$row["nombre_rol"]?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefono1">Teléfono 1</label>
                    <input type="text" class="form-control" id="telefono1" name="telefono1" maxlength="9"
                        pattern="^\d{4}-\d{4}$" title="Formato válido: 1234-5678" oninput="formatoTelefono(this)"
                        >
                </div>
            </div>
            <div class="col-md-6">
                <div class= "form-group">
                    <label for="telefono2">Teléfono 2</label>
                    <input type="text" class="form-control" id="telefono2" name="telefono2" maxlength="9"
                        pattern="^\d{4}-\d{4}$" title="Formato válido: 1234-5678" oninput="formatoTelefono(this)">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fechaContratacion">Fecha de Contratación</label>
                    <input type="date" class="form-control" id="fechaContratacion" name="fechaContratacion" min="2019-01-01" >
                </div>
            </div>
            <div class="col-12">
                    <button class="btn btn-primary" type="submit" >Agregar Empleado</button>
                </div>
            </div>
        </form>
    </div>
                        </div>

    <!-- Scripts de Bootstrap 4 y otros aquí -->

    <script>
        function soloNumeros(e) {
            var key = e.charCode || e.keyCode;
            if (key < 48 || key > 57) {
                e.preventDefault();
            }
        }

        function formatoDUI(input) {
            var dui = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
            if (dui.length > 0) {
                dui = dui.substring(0, 8) + '-' + dui.substring(8, 9); // Agregar guión en la posición adecuada
            }
            input.value = dui; // Actualizar el valor del campo
        }

        function formatoTelefono(input) {
            var telefono = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
            if (telefono.length > 4) {
                telefono = telefono.substring(0, 4) + '-' + telefono.substring(4, 8); // Agregar guión en la posición adecuada
            }
            input.value = telefono; // Actualizar el valor del campo
        }

        function calcularEdad(fecha) {
            var fechaNacimiento = new Date(fecha);
            var fechaActual = new Date();
            var edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();

            if (fechaActual.getMonth() < fechaNacimiento.getMonth() || (fechaActual.getMonth() == fechaNacimiento.getMonth() && fechaActual.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }

            if (edad < 18) {
                Swal.fire("La persona debe ser mayor de 18 años");
                document.getElementById('fechaNacimiento').value = '';
            }
        }

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
    var AllowRegex  = /^[\ba-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/;
    if (AllowRegex.test(character)) return true;
    return false;
}




function validarFormulariocompleto() {
        const dui = document.getElementById('dui').value;
        const nombre = document.getElementById('nombre').value;
        const apellido = document.getElementById('apellido').value;
        const fechaNacimiento = document.getElementById('fechaNacimiento').value;
        const direccion = document.getElementById('direccion').value;
        const rol = document.getElementById('rol').value;
        const telefono1 = document.getElementById('telefono1').value;
        const fechaContratacion = document.getElementById('fechaContratacion').value;

        if (!dui || !nombre || !apellido || !fechaNacimiento || !direccion || rol === '0' || !telefono1 || !fechaContratacion) {
            Swal.fire("Aviso", "Por favor, complete todos los campos antes de enviar el formulario.", "warning");
            return false; // Evitar el envío del formulario
        }

            return true;

    }


    </script>
</body>

</html>
