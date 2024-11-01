<?php
session_start();
include '../models/conexion.php';
$con = connection();
$ejecutar;
$row = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Consulta para obtener información del usuario, incluyendo el estado, desde la tabla 'usuario'
// Se asume que hay una relación entre 'usuario' y 'persona' mediante 'dui_persona'
$consulta_usuario = "SELECT u.usuario, u.contrasena, u.estado, r.nombre as rol
                         FROM usuarios u
                         INNER JOIN roles r
                         ON r.id = u.rol_id
                         WHERE u.usuario = '$row'";

$resultado_usuario = mysqli_query($con, $consulta_usuario);

if ($resultado_usuario) {
    $fila = mysqli_fetch_assoc($resultado_usuario);

    if ($fila) {
        // Verificar el estado del empleado
        if ($fila['estado'] == 1) { // 1 es activo, 0 es inactivo
            // Verificar la contraseña
            if (password_verify($contrasena, $fila['contrasena'])) {
                // Iniciar sesión y redirigir si la contraseña es correcta
                $_SESSION['usuario'] = $row;
                $_SESSION['rol'] = $fila['rol'];

                echo json_encode(array("exito" => "Bienvenido '.$row.'"));
            } else {
                // Contraseña incorrecta
                mostrarMensajeError("Contraseña incorrecta");
            }
        } else {
            // El empleado está inactivo
            mostrarMensajeError("Cuenta desactivada");
        }
    } else {
        // Usuario no encontrado
        echo json_encode(array("error" => "Usuario no encontrado"));
        //mostrarMensajeError("Usuario no encontrado");
    }
} else {
    // Error en la consulta
    mostrarMensajeError("Error en la consulta de usuario");
}

// Función para mostrar mensajes de error y redirigir
function mostrarMensajeError($mensaje)
{
    echo '
    <head>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
            Swal.fire({
            title: "Error",
            text: "' . $mensaje . '",
            icon: "error"
            }).then((result) => {
            if (result.isConfirmed) {
            // Redirigir a otra página cuando el usuario presione "OK"
            window.location = "../index.php";
            }
            });
            </script>
    </body>
        ';
    exit;
}
