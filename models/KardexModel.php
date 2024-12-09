<?php
require_once "conexion.php";

class kardexModel
{

    public static function listar()
    {
        $con = connection();
        $sql = "WITH movimientos AS (
    -- Entradas por compras
    SELECT 
        c.fecha AS fecha_movimiento,
        p.nombre AS nombre_producto,
        'entrada' AS tipo_movimiento,
        dc.cantidad AS unidades,
        dc.precio_unitario AS precio,
        (dc.cantidad * dc.precio_unitario) AS costo_total,
        p.id AS producto_id
    FROM compras c
    JOIN detallecompra dc ON c.id = dc.compra_id
    JOIN productos p ON dc.producto_id = p.id
    WHERE c.activo = TRUE

    UNION ALL

    -- Salidas por ventas
    SELECT 
        v.fecha AS fecha_movimiento,
        p.nombre AS nombre_producto,
        'salida' AS tipo_movimiento,
        dv.cantidad AS unidades,
        dv.precio_unitario AS precio,
        (dv.cantidad * dv.precio_unitario) AS costo_total,
        p.id AS producto_id
    FROM ventas v
    JOIN detalleventa dv ON v.id = dv.venta_id
    JOIN productos p ON dv.producto_id = p.id
)
SELECT 
    m.fecha_movimiento AS fecha,
    m.nombre_producto AS producto,
    
    -- Entradas
    CASE WHEN m.tipo_movimiento = 'entrada' THEN m.unidades ELSE NULL END AS Entrada,
    
    -- Salidas
    CASE WHEN m.tipo_movimiento = 'salida' THEN m.unidades ELSE NULL END AS Salida,
    
    -- Existencia acumulada de unidades por producto
    SUM(
        CASE 
            WHEN m.tipo_movimiento = 'entrada' THEN m.unidades
            WHEN m.tipo_movimiento = 'salida' THEN -m.unidades
            ELSE 0
        END
    ) OVER (PARTITION BY m.producto_id ORDER BY m.fecha_movimiento ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS Existencia,

    -- Cálculo del costo unitario
    CASE 
        WHEN m.tipo_movimiento = 'entrada' THEN m.precio
        WHEN m.tipo_movimiento = 'salida' THEN m.precio
        ELSE NULL
    END AS Costo_Unitario,

    -- Costo Total acumulado por producto
    SUM(
        CASE 
            WHEN m.tipo_movimiento = 'entrada' THEN m.costo_total
            WHEN m.tipo_movimiento = 'salida' THEN -m.costo_total
            ELSE 0
        END
    ) OVER (PARTITION BY m.producto_id ORDER BY m.fecha_movimiento ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS Costo_Total

FROM movimientos m
ORDER BY m.nombre_producto, m.fecha_movimiento;
";
        $query = mysqli_query($con, $sql);
        return $query;
    }
}
