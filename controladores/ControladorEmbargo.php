<?php

require_once "../models/EmbargoModel.php";

class ControladorEmbargo
{
    // Método para listar embargos
    public static function listarEmbargos()
    {
        try {
            $embargos = EmbargoModel::listarEmbargos();
            echo json_encode([
                "error" => false,
                "data" => $embargos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "error" => true,
                "message" => $e->getMessage()
            ]);
        }
    }

    // Método para registrar un embargo
    public static function registrarEmbargo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $cuentaId = intval($_POST['cuenta_id']);
                $motivo = $_POST['motivo'];
                $fechaEmbargo = date('Y-m-d');

                EmbargoModel::registrarEmbargo($cuentaId, $motivo, $fechaEmbargo);

                echo json_encode([
                    "error" => false,
                    "message" => "Embargo registrado con éxito."
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage()
                ]);
            }
        }
    }

    // Método para cambiar el estado de un embargo
    public static function cambiarEstadoEmbargo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $embargoId = intval($_POST['embargo_id']);
                $nuevoEstado = $_POST['nuevo_estado'];

                EmbargoModel::cambiarEstadoEmbargo($embargoId, $nuevoEstado);

                echo json_encode([
                    "error" => false,
                    "message" => "Estado de embargo actualizado con éxito."
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    "error" => true,
                    "message" => $e->getMessage()
                ]);
            }
        }
    }

    // Método para verificar y actualizar automáticamente cuentas vencidas
    public static function verificarYActualizarEmbargos()
    {
        try {
            EmbargoModel::verificarYActualizarEmbargos();
            echo json_encode([
                "error" => false,
                "message" => "Embargos verificados y actualizados con éxito."
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "error" => true,
                "message" => $e->getMessage()
            ]);
        }
    }
}

// Manejo de acciones
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'listar':
            ControladorEmbargo::listarEmbargos();
            break;
        case 'registrar':
            ControladorEmbargo::registrarEmbargo();
            break;
        case 'cambiarEstado':
            ControladorEmbargo::cambiarEstadoEmbargo();
            break;
        case 'verificar':
            ControladorEmbargo::verificarYActualizarEmbargos();
            break;
        default:
            echo json_encode([
                "error" => true,
                "message" => "Acción no válida."
            ]);
            break;
    }
}