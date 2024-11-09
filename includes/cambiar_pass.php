<?php
include '../models/conexion.php';
$con = connection();
$ejecutar;
$password = $_POST['contrasena'];
$usuario = $_POST['usuario'];
//$password = hash('sha512', $password);
$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
$guardar_pass = "UPDATE usuarios set contrasena = '$hash', temp_contra=0 WHERE usuario = '$usuario'";
$ejecutar = mysqli_query($con, $guardar_pass);
if ($ejecutar) {
    echo json_encode(array("exito" => "Contraseña actualizada, por favor inicia sesion con tu nueva contraseña"));
} else {
    echo json_encode(array("error" => "error al guardar"));
}