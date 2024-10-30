<?php
include 'conexion.php';
$ejecutar;
$password = $_POST['newpass'];
$id = $_POST['id'];
//$password = hash('sha512', $password);
$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
$guardar_pass = "UPDATE usuario set contrasenia = '$hash' WHERE id_usuario = '$id'";
$ejecutar = mysqli_query($conexion, $guardar_pass);
echo '
        <script>
           alert("Contraseña Actualizada con exito!!!");
           window.location = "../index.html"
           </script>
    ';

?>