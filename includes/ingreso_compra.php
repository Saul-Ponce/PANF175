<?php
session_start();
include 'conexion.php';
$ejecutar;
$row = $_SESSION['usuario'];
$total = $_POST["totalPrice"];
$zona = date_default_timezone_set("America/El_Salvador");
$fecha = date("Y-m-d h:i:s");
$buscarid_usuario = "SELECT dui_persona from usuario WHERE nombre_u = '$row'";
$ejecutar = mysqli_query($con, $buscarid_usuario);
$fila = mysqli_fetch_row($ejecutar);
$compra = "INSERT INTO compras(fecha_c,gerente,total) VALUES ('$fecha','$fila[0]','$total[0]')";
$ejecutar = mysqli_query($con, $compra);
