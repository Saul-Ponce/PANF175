<?php
require_once("conexion.php");

class MantModel{

	public static function listar()
	{
		$con = connection();
		$sql = " SELECT
		control_mantenimiento.fecha_m, 
		control_mantenimiento.detalles_m, 
		control_mantenimiento.estado_m, 
		control_mantenimiento.precio_m,
		control_mantenimiento.equipo, 
		equipo.marca, 
		equipo.procesador, 
		equipo.ram, 
		equipo.almacenamiento, 
		equipo.dui_cliente, 
		control_mantenimiento.id_cmantenimiento, 
		cliente.nombre_c, 
		cliente.apellido_c
	FROM
		control_mantenimiento
		INNER JOIN
		equipo
		ON 
			control_mantenimiento.equipo = equipo.id_equipo
		INNER JOIN
		cliente
		ON 
			equipo.dui_cliente = cliente.dui_cliente";
		$query = mysqli_query($con, $sql);

		return $query;
	}

	

	public static function agregar($fecha_m, $detalles_m, $estado_m, $precio_m,$equipo)
	{
		$con = connection();


		$sql = "INSERT INTO control_mantenimiento (fecha_m, detalles_m, estado_m, precio_m,equipo) VALUES ('$fecha_m', '$detalles_m', '$estado_m', '$precio_m','$equipo')";
        $querry = mysqli_query($con, $sql);
		
        



	}

	public static function editar($data)
	{

		$con = connection();

		$id= $data['id_cmantenimiento'];
		$fecha  = $data['fecha_m'];
		$detalles = $data['detalles_m'];
		$estado  = $data['estado_m'];
		$precio = $data['precio_m'];
		



		$sql = "UPDATE control_mantenimiento SET fecha_m='$fecha', detalles_m='$detalles', estado_m='$estado', precio_m='$precio'  WHERE id_cmantenimiento='$id'";

		$query = mysqli_query($con, $sql);
	}

	public static function dueño($DUI){

        $con = connection();

		$sql ="SELECT *
	FROM
		cliente
	WHERE
		cliente.dui_cliente = '$DUI'";
		
		$query = mysqli_query($con, $sql);

		return $query;

    }

	
	public static function borrar($id_cmantenimiento){

		$con = connection();
		

		$sql="DELETE FROM control_mantenimiento WHERE id_cmantenimiento='$id_cmantenimiento'";
		$query = mysqli_query($con, $sql);
		
	}

	

	
	
	
}


?>