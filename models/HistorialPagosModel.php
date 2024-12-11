<?php
require_once("conexion.php");

class HistorialPagosModel
{
    // Método para obtener el historial de pagos de una cuenta
    public static function obtenerHistorialPagos($idCuenta)
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "
            SELECT 
                h.id,
                h.fecha_pago,
                h.monto_pagado,
                h.interes_pagado,
                h.capital_abonado,
                h.saldo_restante
            FROM 
                historialpagos h
            WHERE 
                h.cuenta_id = ?
            ORDER BY 
                h.fecha_pago DESC
        ";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idCuenta);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Error al obtener el historial de pagos: " . $con->error);
        }

        $historial = [];
        while ($row = $result->fetch_assoc()) {
            $historial[] = $row;
        }

        $stmt->close();
        $con->close();

        return $historial;
    }

    // Método para registrar un nuevo pago en el historial
    public static function registrarPago($cuentaId, $montoPagado, $interesPagado, $capitalAbonado, $saldoRestante)
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "
            INSERT INTO historialpagos (cuenta_id, fecha_pago, monto_pagado, interes_pagado, capital_abonado, saldo_restante)
            VALUES (?, NOW(), ?, ?, ?, ?)
        ";

        $stmt = $con->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación del registro de pago: " . $con->error);
        }

        $stmt->bind_param("idddi", $cuentaId, $montoPagado, $interesPagado, $capitalAbonado, $saldoRestante);
        $stmt->execute();

        if ($stmt->error) {
            throw new Exception("Error al registrar el pago: " . $stmt->error);
        }

        $stmt->close();
        $con->close();
    }

    // Método para obtener el saldo restante actual de una cuenta
    public static function obtenerSaldoRestante($idCuenta)
    {
        $con = connection();

        if (!$con) {
            throw new Exception("Error al conectar a la base de datos");
        }

        $sql = "
            SELECT 
                h.saldo_restante
            FROM 
                historialpagos h
            WHERE 
                h.cuenta_id = ?
            ORDER BY 
                h.fecha_pago DESC
            LIMIT 1
        ";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $idCuenta);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Error al obtener el saldo restante: " . $con->error);
        }

        $saldo = 0;
        if ($row = $result->fetch_assoc()) {
            $saldo = floatval($row['saldo_restante']);
        }

        $stmt->close();
        $con->close();

        return $saldo;
    }
}
?>
