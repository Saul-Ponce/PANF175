<?php
include 'conexion.php';
$ejecutar;
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$id = $_POST['id'];
$nombreOriginal = $_SESSION['usuario'];
$verificar_usuario = "SELECT count(1) FROM usuario WHERE nombre_u = '$nombre'";
$verificar_correo = "SELECT count(1) FROM usuario WHERE correo = '$correo'";
$ejecutar = mysqli_query($conexion, $verificar_usuario);
$fila = mysqli_fetch_row($ejecutar);
if ($fila[0] > 0) {
    echo '
            <script>
            alert("El nombre de usuario introducido ya ha sido utlizado!!!");
            window.location = "../vistas/perfil.php"
            </script>
            ';

}else{
    $ejecutar = mysqli_query($conexion, $verificar_correo);
    $fila = mysqli_fetch_row($ejecutar);
    if ($fila[0] > 0) {
        echo '
                <script>
                alert("El correo electronico introducido ya ha sido utlizado!!!");
                window.location = "../vistas/perfil.php"
                </script>
                ';
    }else{
        $query = "UPDATE usuario SET nombre_u='$nombre', correo='$correo' WHERE dui_persona='$id'";
                $ejecutar = mysqli_query($conexion, $query);
                if ($ejecutar) {
                    echo '
                 <script>
                 alert("Usuario actualizado Correctamente!!!");
                 window.location = "cerrar_sesion.php"
                 </script>
             ';
                } else {
                    echo '
                 <script>
                 alert("Ha ocurrido un error!!!");
                 window.location = "../vistas/perfil.php"
                 </script>
             ';
                }
    }
}