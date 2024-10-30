<?php
require_once("conexion.php");

class EquipoModel
{

	public static function listar()
	{
		$con = connection();
		$sql = "SELECT\n".
        "	equipo.id_equipo, \n".
		"	equipo.fecha_r, \n".
        "	equipo.marca, \n".
        "	equipo.procesador, \n".
        "	equipo.ram, \n".
        "	equipo.almacenamiento, \n".
        "	equipo.observaciones, \n".
        "	equipo.fecha_entrega, \n".
        "	cliente.dui_cliente\n".
        "FROM\n".
        "	equipo\n".
        "	INNER JOIN\n".
        "	cliente\n".
        "	ON \n".
        "		equipo.dui_cliente = cliente.dui_cliente";

		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($fecha_r, $marca, $procesador, $ram, $almacenamiento, $observaciones,$fecha_entrega,$dui_cliente)
	{
		$con = connection();


		$sql = "INSERT INTO equipo (fecha_r, marca, procesador, ram, almacenamiento, observaciones, fecha_entrega, dui_cliente) VALUES ('$fecha_r','$marca','$procesador','$ram','$almacenamiento', '$observaciones', '$fecha_entrega','$dui_cliente')";
        $querry = mysqli_query($con, $sql);
        



	}

	public static function editar($data)
	{

		$con = connection();

        $id_equipo = $data['id_equipo']; 
		$fecha_r = $data['fecha_r'];
		$marca = $data['marca'];
		$procesador = $data['procesador'];
		$ram = $data['ram'];
		$almacenamiento = $data['almacenamiento'];
		$observaciones = $data['observaciones'];
		$fecha_entrega = $data['fecha_entrega'];
		$dui_cliente = $data['dui_cliente'];
		

		$sql = "UPDATE equipo SET fecha_r='$fecha_r', marca='$marca', procesador='$procesador', ram='$ram', almacenamiento='$almacenamiento', observaciones='$observaciones', fecha_entrega='$fecha_entrega',dui_cliente='$dui_cliente'  WHERE id_equipo='$id_equipo'";
		$query = mysqli_query($con, $sql);

	
	}

	public static function borrar($id_equipo){

		$con = connection();
		

		$sql="DELETE FROM equipo WHERE id_equipo='$id_equipo'";
		$query = mysqli_query($con, $sql);
		
	}
	public static function obtener_equipo($id_equipo){

        $con = connection();
		$sql ="SELECT\n".
        "	equipo.fecha_r, \n".
        "	equipo.marca, \n".
        "	equipo.procesador, \n".
        "	equipo.ram, \n".
        "	equipo.almacenamiento, \n".
        "	equipo.observaciones, \n".
        "	equipo.fecha_entrega, \n".
        "	cliente.dui_cliente\n".
        "FROM\n".
        "	cliente\n".
        "	INNER JOIN\n".
        "	equipo\n".
        "	ON \n".
        "		cliente.dui_cliente = equipo.dui_cliente WHERE id_equipo='$id_equipo'";
		$query = mysqli_query($con, $sql);

		return $query;

    }
	
}


?>