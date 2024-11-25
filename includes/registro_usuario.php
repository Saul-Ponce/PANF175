<?php
include 'conexion.php';
$ejecutar;
$dui = $_POST['dui'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$correo = $_POST['correo'];
//$password = hash('sha512', $password);
$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
$verificar_dui = "SELECT count(1) FROM persona WHERE dui_persona = '$dui'";
$buscar_dui = "SELECT count(1) FROM usuario WHERE dui_persona = '$dui'";
$verificar_usuario = "SELECT count(1) FROM usuario WHERE nombre_u = '$nombre'";
$verificar_correo = "SELECT count(1) FROM usuario WHERE correo = '$correo'";
$ejecutar = mysqli_query($con, $verificar_dui);
$fila = mysqli_fetch_row($ejecutar);
if ($fila[0] > 0) {
    $ejecutar = mysqli_query($con, $buscar_dui);
    $fila = mysqli_fetch_row($ejecutar);
    if ($fila[0] > 0) {
        echo '
                <script>
    alert("El DUI Introducido ya esta vinculado a un usuario!!!");
    window.location = "../index.html"
    </script>
         ';
    } else {
        $ejecutar = mysqli_query($con, $verificar_usuario);
        $fila = mysqli_fetch_row($ejecutar);
        if ($fila[0] > 0) {
            echo '
            <script>
            alert("El nombre de usuario introducido ya ha sido utlizado!!!");
            window.location = "../index.html"
            </script>
            ';
        } else {
            $ejecutar = mysqli_query($con, $verificar_correo);
            $fila = mysqli_fetch_row($ejecutar);
            if ($fila[0] > 0) {
                echo '
                <script>
                alert("El correo electronico introducido ya ha sido utlizado!!!");
                window.location = "../index.html"
                </script>
                ';
            } else {
                $query = "INSERT INTO usuario(nombre_u,contrasenia,correo,dui_persona) VALUES('$nombre', '$hash', '$correo', '$dui')";
                $ejecutar = mysqli_query($con, $query);
                if ($ejecutar) {
                    echo '
                 <script>
                 alert("Usuario almacenado Correctamente!!!");
                 window.location = "../index.html"
                 </script>
             ';
                } else {
                    echo '
                 <script>
                 alert("Ha ocurrido un error!!!");
                 window.location = "../index.html"
                 </script>
             ';
                }
            }
        }
    }
    // echo '
    //          <script>
    //          alert("Dui si existe!!!");
    //          </script>
    //      ';
} else {
    echo '
             <script>
             alert("El DUI Ingresado no esta registrado en el sistema!!!");
             window.location = "../index.html"
             </script>
         ';
}
