<?php

require_once "../models/HistorialPagosModel.php";

class ControladorHistorialPagos
{
    // Método para obtener el historial de pagos de una cuenta
    public static function obtenerHistorialPagos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validación de ID de cuenta
            if (!isset($_POST['idCuenta']) || empty($_POST['idCuenta'])) {
                echo json_encode([
                    "error" => true,
                    "message" => "El ID de la cuenta es obligatorio."
                ]);
                exit();
            }
    
            try {
                $idCuenta = intval($_POST['idCuenta']);
                $historial = HistorialPagosModel::obtenerHistorialPagos($idCuenta);
    
                echo json_encode([
                    "error" => false,
                    "data" => $historial
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage()
                ]);
            }
        }
    }

    // Método para registrar un nuevo pago
    public static function registrarPago()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $cuentaId = intval($_POST['cuentaId']);
                $montoPagado = floatval($_POST['montoPagado']);
                $interesPagado = floatval($_POST['interesPagado']);
                $capitalAbonado = floatval($_POST['capitalAbonado']);

                // Obtener el saldo restante actual
                $saldoActual = HistorialPagosModel::obtenerSaldoRestante($cuentaId);
                $saldoRestante = $saldoActual - $capitalAbonado;

                if ($saldoRestante < 0) {
                    throw new Exception("El capital abonado excede el saldo restante.");
                }

                HistorialPagosModel::registrarPago($cuentaId, $montoPagado, $interesPagado, $capitalAbonado, $saldoRestante);

                echo json_encode([
                    "error" => false,
                    "message" => "Pago registrado exitosamente."
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage()
                ]);
            }
        }
    }
}

// Manejo de acciones
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'obtenerHistorial':
            ControladorHistorialPagos::obtenerHistorialPagos();
            break;
        case 'registrarPago':
            ControladorHistorialPagos::registrarPago();
            break;
        default:
            echo json_encode([
                "error" => true,
                "message" => "Acción no válida."
            ]);
            break;
    }
}

?>
