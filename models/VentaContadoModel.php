<?php
require_once("conexion.php");

class VentaModel
{

	public static function listar()
	{
		$con = connection();

		$sql = "SELECT
			v.*, 
			cj.nombre as cjurdico, 
			cn.nombre as cnatural,
			u.nombre as usuario
		FROM
			ventas AS v
			LEFT JOIN
			clientesjuridicos AS cj
			ON 
				v.cliente_juridico_id = cj.id
			LEFT JOIN
			clientesnaturales AS cn
			ON 
				v.cliente_natural_id = cn.id
			INNER JOIN
			usuarios AS u
			ON 
				v.usuario_id = u.id";
		$result = mysqli_query($con, $sql);
		return $result;
	}

	public static function listarDet($id)
	{
		$con = connection();

		$sql = "	SELECT
			p.nombre, 
			d.cantidad,
			d.precio_unitario
		FROM
			detalleventa AS d
			INNER JOIN
			ventas AS v
			ON 
				v.id = d.venta_id
			INNER JOIN
			productos AS p
			ON 
				d.producto_id = p.id
				where d.venta_id='$id'";
		$result = mysqli_query($con, $sql);
		$tabla = "";
		$htmltr = "";
		foreach ($result as $row) {
			$htmltr .= '<tr>
	                            <td>' . $row['nombre'] . '</td>
	                            <td>' . $row['cantidad'] . '</td>
	                            <td>$' . $row['precio_unitario'] . '</td>
	                        </tr>';
		}
		$tabla .= '<table id="tabla_detalleVC" class="table table-bordered text-center align-middle" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                        </tr>
                    </thead>
                    <tbody>';
		$tabla .= $htmltr;
		$tabla .= '</tbody>
                    	</table>';

		return $tabla;
	}




	public static function agregar($fecha_venta, $tipo_venta, $tipo_cliente, $cliente, $usuario, $total, $data)
	{
		$con = connection();

		$sql = $tipo_cliente == "natural" ? "INSERT INTO ventas (fecha, tipo_venta, cliente_natural_id, total_venta, usuario_id) VALUES ('$fecha_venta', '$tipo_venta', $cliente, $total, $usuario)" : "INSERT INTO ventas (fecha, tipo_venta, cliente_juridico_id, total_venta, usuario_id) VALUES ('$fecha_venta', '$tipo_venta', $cliente, $total, $usuario)";

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
			$producto = $item['product'];
			$cantidad = $item['quantity'];
			$precio = $item['price'];
			$id_inventario = $item['inv'];

			// Update the stock of the product in the database
			$sqlUpdateStock = "UPDATE inventario SET stok=stok - $cantidad
			WHERE idInventario=$id_inventario;";
			$queryUpdateStock = mysqli_query($con, $sqlUpdateStock);

			$sql = "INSERT INTO detalleventa
			(venta_id, producto_id, cantidad, precio_unitario)
			VALUES( $id, $producto, $cantidad, $precio);";

			$querry = mysqli_query($con, $sql);



		}
	}


	public static function editar($data)
	{

		$con = connection();

		$id = $data['id_Venta'];
		$fecha_c = $data['fecha_c'];
		$gerente = $data['gerente'];





		$sql = "UPDATE Ventas SET fecha_c='$fecha_c', gerente='$gerente'  WHERE id_Venta='$id'";

		$query = mysqli_query($con, $sql);
	}

	public static function borrar($id_Venta)
	{

		$con = connection();


		$sql = "DELETE FROM Ventas WHERE id_Venta='$id_Venta'";
		$query = mysqli_query($con, $sql);


	}








}


?>