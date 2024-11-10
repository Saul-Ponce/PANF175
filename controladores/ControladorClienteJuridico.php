<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../models/ClienteJuridicoModel.php");

class ControladorClienteJuridico
{
    public static function listar()
    {
        return ClienteJuridicoModel::listar();
    }

    public static function agregar($data)
    {
        try {
            // Escapar y preparar los datos del cliente jurídico
            $data['nombre'] = htmlspecialchars(trim($data['nombre']));
            $data['direccion'] = htmlspecialchars(trim($data['direccion']));
            $data['telefono'] = htmlspecialchars(trim($data['telefono']));
            $data['email'] = htmlspecialchars(trim($data['email']));
            $data['clasificacion_id'] = (int)$data['clasificacion_id'];
            $data['estado'] = htmlspecialchars(trim($data['estado'] ?? 'activo'));

            // Procesar archivo 'aval' si está presente
            if (isset($_FILES['aval']) && $_FILES['aval']['error'] == 0) {
                $data['aval'] = file_get_contents($_FILES['aval']['tmp_name']);
            } else {
                $data['aval'] = null; // No hay archivo subido
            }

            // Verificamos si existen los datos del representante legal y los agregamos a $representanteData
            $representanteData = [
                'nombre_representante' => htmlspecialchars(trim($data['nombre_representante'] ?? '')),
                'direccion_representante' => htmlspecialchars(trim($data['direccion_representante'] ?? '')),
                'telefono_representante' => htmlspecialchars(trim($data['telefono_representante'] ?? '')),
                'email_representante' => htmlspecialchars(trim($data['email_representante'] ?? '')),
                'dui_representante' => htmlspecialchars(trim($data['dui_representante'] ?? ''))
            ];

            // Llamamos al modelo para agregar el cliente y su representante legal
            ClienteJuridicoModel::agregar($data, $representanteData);

            $_SESSION['success_messageC'] = "Cliente Jurídico agregado exitosamente.";
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        } catch (Exception $e) {
            // Manejo de la excepción
            $_SESSION['error_messageC'] = "Error al agregar el Cliente Jurídico: " . $e->getMessage();
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        }
    }

    public static function editar($data)
    {
        try {
            // Escapar y preparar los datos del cliente jurídico
            $data['id'] = (int)$data['id'];
            $data['nombre'] = htmlspecialchars(trim($data['nombre']));
            $data['direccion'] = htmlspecialchars(trim($data['direccion']));
            $data['telefono'] = htmlspecialchars(trim($data['telefono']));
            $data['email'] = htmlspecialchars(trim($data['email']));
            $data['clasificacion_id'] = (int)$data['clasificacion_id'];

            // Procesar archivo 'aval' si está presente
            if (isset($_FILES['aval']) && $_FILES['aval']['error'] == 0) {
                $data['aval'] = file_get_contents($_FILES['aval']['tmp_name']);
            } else {
                $data['aval'] = null; // Mantener el archivo existente si no hay nuevo archivo
            }

            // Llamamos al modelo para editar el cliente jurídico
            ClienteJuridicoModel::editar($data);

            $_SESSION['success_messageC'] = "Cliente Jurídico actualizado exitosamente.";
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        } catch (Exception $e) {
            // Manejo de la excepción
            $_SESSION['error_messageC'] = "Error al actualizar el Cliente Jurídico: " . $e->getMessage();
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        }
    }

    public static function editarRepresentante($data)
    {
        try {
            // Escapar y preparar los datos del representante legal
            $data['representante_legal_id'] = (int)$data['representante_legal_id'];
            $data['nombre_representante'] = htmlspecialchars(trim($data['nombre_representante']));
            $data['direccion_representante'] = htmlspecialchars(trim($data['direccion_representante']));
            $data['telefono_representante'] = htmlspecialchars(trim($data['telefono_representante']));
            $data['email_representante'] = htmlspecialchars(trim($data['email_representante']));
            $data['dui_representante'] = htmlspecialchars(trim($data['dui_representante']));

            // Llamamos al modelo para editar el representante legal
            ClienteJuridicoModel::editarRepresentante($data);

            $_SESSION['success_messageC'] = "Representante Legal actualizado exitosamente.";
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        } catch (Exception $e) {
            // Manejo de la excepción
            $_SESSION['error_messageC'] = "Error al actualizar el Representante Legal: " . $e->getMessage();
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        }
    }

    public static function cambiarEstado($id, $estado)
    {
        try {
            $id = (int)$id;
            $estado = htmlspecialchars(trim($estado));

            ClienteJuridicoModel::cambiarEstado($id, $estado);
            $_SESSION['success_messageC'] = "Estado del Cliente Jurídico cambiado exitosamente.";
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        } catch (Exception $e) {
            // Manejo de la excepción
            $_SESSION['error_messageC'] = "Error al cambiar el estado del Cliente Jurídico: " . $e->getMessage();
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        }
    }
}

if ($_POST) {
    switch ($_POST['action']) {
        case 'insert':
            ControladorClienteJuridico::agregar($_POST);
            break;
        case 'edit':
            ControladorClienteJuridico::editar($_POST);
            break;
        case 'editRepresentante':
            ControladorClienteJuridico::editarRepresentante($_POST);
            break;
        case 'cambiarEstado':
            ControladorClienteJuridico::cambiarEstado($_POST['id'], $_POST['estado']);
            break;
        default:
            // Acción no reconocida
            $_SESSION['error_messageC'] = "Acción no reconocida.";
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
    }
}
?>
