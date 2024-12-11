<?php
require_once("conexion.php");

class CuentasPorCobrarModel
{
    // Método para listar todas las cuentas por cobrar
    public static function listarCuentas()
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "
            SELECT 
                c.id, 
                v.id AS venta_id, 
                v.tipo_venta, 
                IFNULL(cn.nombre, cj.nombre) AS cliente, 
                c.monto, 
                c.saldo, 
                c.plazo_cobro, 
                c.fecha_vencimiento, 
                c.estado 
            FROM 
                cuentasporcobrar c
            INNER JOIN ventas v ON c.venta_id = v.id
            LEFT JOIN clientesnaturales cn ON v.cliente_natural_id = cn.id
            LEFT JOIN clientesjuridicos cj ON v.cliente_juridico_id = cj.id
            ORDER BY c.fecha_vencimiento ASC
        ";

        $result = mysqli_query($con, $sql);

        if (!$result) {
            throw new Exception("Error al listar cuentas por cobrar: " . mysqli_error($con));
        }

        $cuentas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $cuentas[] = $row;
        }

        $con->close();
        return $cuentas;
    }

    // Método para registrar un pago
    public static function registrarPago($cuenta_id, $monto_pagado, $interes_pagado, $capital_abonado)
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $con->begin_transaction();

        try {
            $sqlSaldo = "SELECT saldo FROM cuentasporcobrar WHERE id = ? FOR UPDATE";
            $stmtSaldo = $con->prepare($sqlSaldo);
            $stmtSaldo->bind_param("i", $cuenta_id);
            $stmtSaldo->execute();
            $resultSaldo = $stmtSaldo->get_result();

            if ($resultSaldo->num_rows === 0) {
                throw new Exception("Cuenta no encontrada");
            }

            $saldoActual = $resultSaldo->fetch_assoc()['saldo'];

            if ($monto_pagado > $saldoActual) {
                throw new Exception("El monto pagado no puede ser mayor al saldo actual");
            }

            $saldoRestante = $saldoActual - $monto_pagado;

            $sqlInsert = "
                INSERT INTO historialpagos (cuenta_id, fecha_pago, monto_pagado, interes_pagado, capital_abonado, saldo_restante)
                VALUES (?, NOW(), ?, ?, ?, ?)
            ";
            $stmtInsert = $con->prepare($sqlInsert);
            $stmtInsert->bind_param("idddi", $cuenta_id, $monto_pagado, $interes_pagado, $capital_abonado, $saldoRestante);
            $stmtInsert->execute();

            $estado = $saldoRestante <= 0 ? 'pagado' : 'pendiente';
            $sqlUpdate = "UPDATE cuentasporcobrar SET saldo = ?, estado = ? WHERE id = ?";
            $stmtUpdate = $con->prepare($sqlUpdate);
            $stmtUpdate->bind_param("dsi", $saldoRestante, $estado, $cuenta_id);
            $stmtUpdate->execute();

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        } finally {
            $stmtSaldo->close();
            $stmtInsert->close();
            $stmtUpdate->close();
            $con->close();
        }
    }

    // Método para calcular mora
    public static function calcularMora($cuenta_id, $mora_porcentual)
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "SELECT saldo, fecha_vencimiento FROM cuentasporcobrar WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $cuenta_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Cuenta no encontrada");
        }

        $cuenta = $result->fetch_assoc();
        $fechaVencimiento = new DateTime($cuenta['fecha_vencimiento']);
        $hoy = new DateTime();

        if ($hoy > $fechaVencimiento) {
            $diasRetraso = $fechaVencimiento->diff($hoy)->days;
            $mora = ($cuenta['saldo'] * $mora_porcentual) / 100;
            $nuevoSaldo = $cuenta['saldo'] + $mora;

            $sqlUpdate = "UPDATE cuentasporcobrar SET saldo = ?, estado = 'atrasado' WHERE id = ?";
            $stmtUpdate = $con->prepare($sqlUpdate);
            $stmtUpdate->bind_param("di", $nuevoSaldo, $cuenta_id);
            $stmtUpdate->execute();

            $stmtUpdate->close();

            return [
                "mora" => $mora,
                "dias_retraso" => $diasRetraso
            ];
        } else {
            return [
                "mora" => 0,
                "dias_retraso" => 0
            ];
        }
    }

    // Método para marcar una cuenta como pagada
    public static function marcarComoPagada($cuenta_id)
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "UPDATE cuentasporcobrar SET estado = 'pagado', saldo = 0 WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $cuenta_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            throw new Exception("No se encontró la cuenta o ya estaba marcada como pagada.");
        }

        $stmt->close();
        $con->close();
    }
}
?>
