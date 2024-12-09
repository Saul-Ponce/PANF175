<?php
require_once("conexion.php");

class VentaCreditoModel
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
            ventas AS v
            LEFT JOIN
            cliente AS c ON (v.cliente_natural_id = c.id OR v.cliente_juridico_id = c.id)
            INNER JOIN
            usuarios AS p ON v.usuario_id = p.id";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    public static function listarDet($id)
    {
        $con = connection();
        
        // Escapar el id para prevenir inyección SQL
        $id = mysqli_real_escape_string($con, $id);

        $sql = "SELECT
            p.nombre_p, 
            d.cantidad,
            d.cantidad * d.precio_unitario AS precioDet
        FROM
            detalleventa AS d
            INNER JOIN
            producto AS p ON d.producto_id = p.id
        WHERE d.venta_id = '$id'";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    public static function agregar($fecha_venta, $cliente, $empleado, $total, $data, $aval)
    {
        $con = connection();

        $sql = $con->prepare("INSERT INTO ventas (fecha, tipo_venta, cliente_natural_id, cliente_juridico_id, total_venta, usuario_id, aval) 
                               VALUES (?, 'credito', ?, ?, ?, ?, ?)");
        $clienteNatural = $clienteJuridico = null;

        // Dependiendo del cliente, asignar a la columna correspondiente
        if ($_POST['tipo-cliente'] === 'cliente-natural') {
            $clienteNatural = $cliente;
        } else {
            $clienteJuridico = $cliente;
        }

        $sql->bind_param("siiiss", $fecha_venta, $clienteNatural, $clienteJuridico, $total, $empleado, $aval);
        $sql->execute();

        if ($sql->error) {
            die("Error al insertar la venta: " . $sql->error);
        }

        $venta_id = $sql->insert_id;

        self::agregarDet($venta_id, $data);

        mysqli_close($con);
    }

    public static function agregarDet($id, $data)
    {
        $con = connection();

        // Escapar el id
        $id = mysqli_real_escape_string($con, $id);

        foreach ($data as $item) {
            // Escapar variables
            $producto = mysqli_real_escape_string($con, $item['code']);
            $cantidad = intval($item['quantity']);
            $precio_unitario = floatval($item['price']);

            // Actualizar el stock del producto en la base de datos
            $sqlUpdateStock = "UPDATE producto SET stock = stock - $cantidad WHERE id = '$producto'";
            $queryUpdateStock = mysqli_query($con, $sqlUpdateStock);

            if (!$queryUpdateStock) {
                die("Error al actualizar el stock: " . mysqli_error($con));
            }

            $sql = "INSERT INTO detalleventa (venta_id, producto_id, cantidad, precio_unitario) 
                    VALUES ('$id', '$producto', '$cantidad', '$precio_unitario')";

            $query = mysqli_query($con, $sql);

            if (!$query) {
                die("Error al insertar en detalleventa: " . mysqli_error($con));
            }
        }

        mysqli_close($con);
    }
}
?>
