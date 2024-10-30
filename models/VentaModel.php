<?php
require_once("conexion.php");

class VentaModel
{

	public static function listar()
    {
		$con = connection();
			
			$sql = "SELECT
			v.*, 
			c.*, 
			p.nombre, 
			p.apellido
		FROM
			venta AS v
			INNER JOIN
			cliente AS c
			ON 
				v.cliente = c.dui_cliente
			INNER JOIN
			persona AS p
			ON 
				v.empleado = p.dui_persona";
			$result = mysqli_query($con,$sql);
            return $result; 
    }

	public static function listarDet($id)
    {
		$con = connection();
			
			$sql = "	SELECT
			p.nombre_p, 
			d.cantidad,
			d.cantidad*p.precio as precioDet
		FROM
			venta AS v
			INNER JOIN
			detalleventa AS d
			ON 
				v.id_venta = d.venta
			INNER JOIN
			producto AS p
			ON 
				d.producto = p.codigo_producto
				where id_venta='$id'";
			$result = mysqli_query($con,$sql);
            return $result; 
    }

	

	public static function agregar($fecha_venta, $cliente, $empleado, $total, $data)
	{
		$con = connection();


		$sql = "INSERT INTO venta (fecha_venta, cliente, empleado, total) VALUES ('$fecha_venta','$cliente','$empleado','$total')";
		
        $querry = mysqli_query($con, $sql);
		$venta_id = mysqli_insert_id($con);
		mysqli_close($con);

		self::agregarDet($venta_id, $data);
        



	}

	public static function agregarDet($id, $data)
	{
		$con = connection();

		 // Extract data from the array
		 foreach ($data as $item) {
		 $producto = $item['code'];
		 $cantidad = $item['quantity'];

		  // Update the stock of the product in the database
		  $sqlUpdateStock = "UPDATE producto SET stock = stock - $cantidad WHERE codigo_producto = '$producto'";
		  $queryUpdateStock = mysqli_query($con, $sqlUpdateStock);


		$sql = "INSERT INTO detalleventa (venta, producto, cantidad) VALUES ('$id','$producto','$cantidad')";
		
        $querry = mysqli_query($con, $sql);
        


		 }
	}


	public static function editar($data)
	{

		$con = connection();

		$id  = $data['id_Venta'];
		$fecha_c = $data['fecha_c'];
		$gerente = $data['gerente'];
		




		$sql = "UPDATE Ventas SET fecha_c='$fecha_c', gerente='$gerente'  WHERE id_Venta='$id'";

		$query = mysqli_query($con, $sql);
	}

	public static function borrar($id_Venta){

		$con = connection();
		

		$sql="DELETE FROM Ventas WHERE id_Venta='$id_Venta'";
		$query = mysqli_query($con, $sql);
		
		
	}
	


	

	
	
	
}


?>