<?php
require_once("conexion.php");

class PersonaModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT\n".
		"	persona.dui_persona, \n".
		"	persona.nombre, \n".
		"	persona.apellido, \n".
		"	persona.fecha_nacimiento, \n".
		"	persona.direccion, \n".
		"	persona.telefono1, \n".
		"	persona.telefono2, \n".
		"	persona.rol, \n".
		"	persona.fecha_contratacion, \n".
		"	persona.estado,\n".
		"	rol.nombre_rol\n".
		"FROM\n".
		"	persona\n".
		"	INNER JOIN\n".
		"	rol\n".
		"	ON \n".
		"		persona.rol = rol.id_rol";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($dui_persona, $nombre, $apellido, $fecha_nacimiento, $direccion, $rol,$telefono1,$telefono2,$fecha_contratacion, $estado)
	{
		$con = connection();


		$sql = "INSERT INTO persona (dui_persona, nombre, apellido, fecha_nacimiento, direccion, rol, telefono1, telefono2, fecha_contratacion, estado) VALUES ('$dui_persona','$nombre','$apellido','$fecha_nacimiento','$direccion', '$rol', '$telefono1','$telefono2','$fecha_contratacion', '$estado')";
        $querry = mysqli_query($con, $sql);
        



	}

	public static function editar($data)
	{

		$con = connection();

		$dui_persona = $data['dui_persona'];
		$nombre = $data['nombre'];
		$apellido = $data['apellido'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$direccion = $data['direccion'];
		$rol = $data['rol'];
		$telefono1 = $data['telefono1'];
		$telefono2 = $data['telefono2'];
		$fecha_contratacion= $data['fecha_contratacion'];

		$sql = "UPDATE persona SET dui_persona='$dui_persona', nombre='$nombre', apellido='$apellido', fecha_nacimiento='$fecha_nacimiento',direccion='$direccion', rol='$rol', telefono1='$telefono1',telefono2='$telefono2', fecha_contratacion='$fecha_contratacion'   WHERE dui_persona='$dui_persona'";
		$query = mysqli_query($con, $sql);

	
	}

	public static function borrar($dui_persona){

		$con = connection();
		

		$sql="DELETE FROM persona WHERE dui_persona='$dui_persona'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function obtener_persona($dui_persona){

        $con = connection();
		$sql ="SELECT\n".
		"	persona.dui_persona, \n".
		"	persona.nombre, \n".
		"	persona.apellido, \n".
		"	persona.fecha_nacimiento, \n".
		"	persona.direccion, \n".
		"	persona.fecha_contratacion, \n".
		"	rol.nombre_rol\n".
		"FROM\n".
		"	persona\n".
		"	INNER JOIN\n".
		"	rol\n".
		"	ON \n".
		"		persona.rol = rol.id_rol WHERE dui_persona = '$dui_persona'";
		$query = mysqli_query($con, $sql);

		return $query;

    }
	public static function cambiarEstado($dui_persona,$estado){

		$con = connection();
		

		$sql = "UPDATE persona SET estado='$estado'  WHERE dui_persona='$dui_persona'";
		$query = mysqli_query($con, $sql);
		
	}
	
}


?>