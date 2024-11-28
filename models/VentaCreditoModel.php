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
            venta_credito AS v
            INNER JOIN
            cliente AS c ON v.cliente = c.dui_cliente
            INNER JOIN
            persona AS p ON v.empleado = p.dui_persona";
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
            d.cantidad * p.precio AS precioDet
        FROM
            venta_credito AS v
            INNER JOIN
            detalleventa_credito AS d ON v.id_venta = d.venta
            INNER JOIN
            producto AS p ON d.producto = p.codigo_producto
        WHERE v.id_venta = '$id'";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    public static function agregar($fecha_venta, $cliente, $empleado, $total, $data, $aval)
    {
        $con = connection();

        // Escapar variables para prevenir inyección SQL
        $fecha_venta = mysqli_real_escape_string($con, $fecha_venta);
        $cliente = mysqli_real_escape_string($con, $cliente);
        $empleado = mysqli_real_escape_string($con, $empleado);
        $total = mysqli_real_escape_string($con, $total);
        $aval = mysqli_real_escape_string($con, $aval);

        $sql = "INSERT INTO venta_credito (fecha_venta, cliente, empleado, total, aval) VALUES ('$fecha_venta', '$cliente', '$empleado', '$total', '$aval')";

        $query = mysqli_query($con, $sql);
        if (!$query) {
            die("Error al insertar la venta: " . mysqli_error($con));
        }

        $venta_id = mysqli_insert_id($con);

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

            // Actualizar el stock del producto en la base de datos
            $sqlUpdateStock = "UPDATE producto SET stock = stock - $cantidad WHERE codigo_producto = '$producto'";
            $queryUpdateStock = mysqli_query($con, $sqlUpdateStock);

            if (!$queryUpdateStock) {
                die("Error al actualizar el stock: " . mysqli_error($con));
            }

            $sql = "INSERT INTO detalleventa_credito (venta, producto, cantidad) VALUES ('$id', '$producto', '$cantidad')";

            $query = mysqli_query($con, $sql);

            if (!$query) {
                die("Error al insertar en detalleventa_credito: " . mysqli_error($con));
            }
        }

        mysqli_close($con);
    }

    // Métodos adicionales si es necesario, como editar y borrar
}
?>
