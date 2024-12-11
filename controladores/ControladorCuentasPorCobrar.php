<?php

require_once "../models/CuentasPorCobrarModel.php";

class ControladorCuentasPorCobrar
{
    // Método para listar cuentas por cobrar
    public static function listarCuentasPorCobrar()
    {
        try {
            $cuentas = CuentasPorCobrarModel::listarCuentas();
            echo json_encode([
                "error" => false,
                "data" => $cuentas
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "error" => true,
                "message" => $e->getMessage()
            ]);
        }
    }

    // Método para registrar pagos
    public static function registrarPago()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Validar datos requeridos
                if (!isset($_POST['idCuenta']) || empty($_POST['idCuenta'])) {
                    throw new Exception("El ID de la cuenta es obligatorio.");
                }
                if (!isset($_POST['montoPagado']) || empty($_POST['montoPagado'])) {
                    throw new Exception("El monto pagado es obligatorio.");
                }

                $idCuenta = intval($_POST['idCuenta']);
                $montoPagado = floatval($_POST['montoPagado']);
                $interesPagado = floatval($_POST['interesPagado'] ?? 0);
                $capitalAbonado = floatval($_POST['capitalAbonado'] ?? 0);

                // Registrar el pago
                CuentasPorCobrarModel::registrarPago($idCuenta, $montoPagado, $interesPagado, $capitalAbonado);

                echo json_encode([
                    "error" => false,
                    "message" => "Pago registrado con éxito."
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage()
                ]);
            }
        }
    }

    // Método para calcular mora
    public static function calcularMora()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (!isset($_POST['idCuenta']) || empty($_POST['idCuenta'])) {
                    throw new Exception("El ID de la cuenta es obligatorio.");
                }
                if (!isset($_POST['moraPorcentual']) || empty($_POST['moraPorcentual'])) {
                    throw new Exception("La tasa de mora es obligatoria.");
                }

                $idCuenta = intval($_POST['idCuenta']);
                $moraPorcentual = floatval($_POST['moraPorcentual']);

                $moraData = CuentasPorCobrarModel::calcularMora($idCuenta, $moraPorcentual);

                echo json_encode([
                    "error" => false,
                    "mora" => $moraData
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage()
                ]);
            }
        }
    }

    // Método para marcar como pagada
    public static function marcarComoPagada()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (!isset($_POST['idCuenta']) || empty($_POST['idCuenta'])) {
                    throw new Exception("El ID de la cuenta es obligatorio.");
                }

                $idCuenta = intval($_POST['idCuenta']);

                CuentasPorCobrarModel::marcarComoPagada($idCuenta);

                echo json_encode([
                    "error" => false,
                    "message" => "Cuenta marcada como pagada."
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

    try {
        switch ($action) {
            case 'listar':
                ControladorCuentasPorCobrar::listarCuentasPorCobrar();
                break;
            case 'registrarPago':
                ControladorCuentasPorCobrar::registrarPago();
                break;
            case 'calcularMora':
                ControladorCuentasPorCobrar::calcularMora();
                break;
            case 'marcarComoPagada':
                ControladorCuentasPorCobrar::marcarComoPagada();
                break;
            default:
                echo json_encode([
                    "error" => true,
                    "message" => "Acción no válida."
                ]);
                break;
        }
    } catch (Exception $e) {
        echo json_encode([
            "error" => true,
            "message" => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "error" => true,
        "message" => "No se especificó ninguna acción."
    ]);
}
