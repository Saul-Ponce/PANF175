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
            $data['nit'] = htmlspecialchars(trim($data['nit']));
            $data['nrc'] = htmlspecialchars(trim($data['nrc']));

            // Validar formato de NIT y NRC
            if (!self::validarFormatoNIT($data['nit'])) {
                throw new Exception("El formato del NIT no es válido. Debe ser XXXX-XXXXXX-XXX-X");
            }
            if (!self::validarFormatoNRC($data['nrc'])) {
                throw new Exception("El formato del NRC no es válido. Debe ser XXXXXX-X");
            }

            // Validar que solo contengan números y guiones
            if (!self::validarSoloNumerosYGuiones($data['nit']) || !self::validarSoloNumerosYGuiones($data['nrc'])) {
                throw new Exception("NIT y NRC solo pueden contener números y guiones");
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
            $data['nit'] = htmlspecialchars(trim($data['nit']));
            $data['nrc'] = htmlspecialchars(trim($data['nrc']));
            $data['clasificacion_id'] = (int)$data['clasificacion_id']; // Validación adicional

            // Validar formato de NIT y NRC
            if (!self::validarFormatoNIT($data['nit'])) {
                throw new Exception("El formato del NIT no es válido. Debe ser XXXX-XXXXXX-XXX-X");
            }
            if (!self::validarFormatoNRC($data['nrc'])) {
                throw new Exception("El formato del NRC no es válido. Debe ser XXXXXX-X");
            }

            // Llamar al modelo para editar
            ClienteJuridicoModel::editar($data);

            $_SESSION['success_messageC'] = "Cliente Jurídico actualizado exitosamente.";
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error_messageC'] = "Error al actualizar el Cliente Jurídico: " . $e->getMessage();
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
        }
    }


    // Función para validar formato del NIT
    private static function validarFormatoNIT($nit)
    {
        return preg_match('/^\d{4}-\d{6}-\d{3}-\d{1}$/', $nit);
    }

    // Función para validar formato del NRC
    private static function validarFormatoNRC($nrc)
    {
        return preg_match('/^\d{6}-\d{1}$/', $nrc);
    }

    // Función para validar que solo contenga números y guiones
    private static function validarSoloNumerosYGuiones($valor)
    {
        return preg_match('/^[0-9-]+$/', $valor);
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

// Manejo de las solicitudes POST
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
            $_SESSION['error_messageC'] = "Acción no reconocida.";
            header("Location: ../vistas/lista-clientesjuridicos.php");
            exit();
    }
}
