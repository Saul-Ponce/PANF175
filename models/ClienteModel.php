<?php
require_once("conexion.php");

class ClienteModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT * FROM cliente";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($dui,$nombre,$apellido,$direccion,$telefono)
	{
		$con = connection();
		$sql = "INSERT INTO cliente (dui_cliente, nombre_c, apellido_c, direccion, telefono_c) VALUES ('$dui','$nombre','$apellido','$direccion','$telefono')";
        $query = mysqli_query($con, $sql);
		return $query;
	}

	public static function editar($data)
	{

		$con = connection();

		$dui = $data['dui'];
		$nombre = $data['nombre'];
		$apellido = $data['apellido'];
		$direccion = $data['direccion'];
		$telefono = $data['telefono'];
		$sql = "UPDATE cliente SET nombre_c='$nombre', apellido_c='$apellido', direccion='$direccion',telefono_c='$telefono' WHERE dui_cliente='$dui'";
		$query = mysqli_query($con, $sql);

	
	}

	public static function borrar($dui){

		$con = connection();
		

		$sql="DELETE FROM cliente WHERE dui_cliente='$dui'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function obtener_cliente($dui){

        $con = connection();
		$sql ="SELECT * FROM cliente WHERE dui_cliente = '$dui'";
		$query = mysqli_query($con, $sql);
		return $query;
    }
}
?>