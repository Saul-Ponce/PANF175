<?php
require_once("conexion.php");

class ProveedorModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT * FROM proveedores";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($nombre, $direccion, $telefono, $correo)
	{
		$con = connection();


		$sql = "INSERT INTO proveedores (nombre, direccion, telefono, email) VALUES ('$nombre','$direccion', '$telefono', '$correo')";
        $query = mysqli_query($con, $sql);
        



	}

	public static function editar($data)
	{

		$con = connection();

        $id_proveedor = $data['id'];
		$nombre = $data['nombre'];
		$direccion = $data['direccion'];
		$telefono = $data['telefono'];
		$correo = $data['correo'];

		

		$sql = "UPDATE proveedores SET nombre='$nombre',  direccion='$direccion', telefono='$telefono', email='$correo'   WHERE id='$id_proveedor'";
		$query = mysqli_query($con, $sql);

	
	}

	public static function borrar($id){

		$con = connection();
		

		$sql="DELETE FROM proveedores WHERE id='$id'";
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
	
	public static function cambiarEstado($data)
    {
        $con = connection();
        $id = $data['id'];
        $estado = $data['estado'];
        $sql = $estado ? "UPDATE proveedores SET estado=$estado WHERE id='$id'" : "UPDATE proveedores SET estado='$estado' WHERE id='$id'";
        $query = mysqli_query($con, $sql);
    }
	
}


?>