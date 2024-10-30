<?php
require_once("conexion.php");

class ProveedorModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT\n".
        "	proveedor.id_proveedor, \n".
        "	proveedor.nombre_p, \n".
        "	proveedor.direccion, \n".
        "	proveedor.telefono\n".
        "FROM\n".
        "	proveedor";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($nombre_p, $direccion, $telefono)
	{
		$con = connection();


		$sql = "INSERT INTO proveedor (nombre_p, direccion, telefono) VALUES ('$nombre_p','$direccion', '$telefono')";
        $query = mysqli_query($con, $sql);
        



	}

	public static function editar($data)
	{

		$con = connection();

        $id_proveedor = $data['id_proveedor'];
		$nombre = $data['nombre_p'];
		$direccion = $data['direccion'];
		$telefono = $data['telefono'];

		

		$sql = "UPDATE proveedor SET nombre_p='$nombre',  direccion='$direccion', telefono='$telefono'   WHERE id_proveedor='$id_proveedor'";
		$query = mysqli_query($con, $sql);

	
	}

	public static function borrar($id_proveedor){

		$con = connection();
		

		$sql="DELETE FROM proveedor WHERE id_proveedor='$id_proveedor'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function obtener_persona($id_proveedor){

        $con = connection();
		$sql = "SELECT\n".
        "	proveedor.id_proveedor, \n".
        "	proveedor.nombre_p, \n".
        "	proveedor.direccion, \n".
        "	proveedor.telefono\n".
        "FROM\n".
        "	proveedor WHERE id_proveedor = '$id_proveedor'";
		$query = mysqli_query($con, $sql);

		return $query;

    }
	
	public static function esEliminable($id_proveedor){
		
		$con = connection();
		$sql = "SELECT\n".
		"	proveedor.*\n".
		"FROM\n".
		"	producto\n".
		"	INNER JOIN\n".
		"	proveedor\n".
		"	ON \n".
		"		producto.proveedor = proveedor.id_proveedor WHERE id_proveedor= $id_proveedor";
		$result = mysqli_query($con, $sql);
		
		// Verificar si hay resultados
		if (mysqli_num_rows($result) > 0) {
			// Si hay resultados
			return true;
		} else {
			// Si no hay resultados
			return false;
		}
				
	}
	
}


?>