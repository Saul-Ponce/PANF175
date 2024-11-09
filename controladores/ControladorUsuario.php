<?php
require_once '../models/UsuarioModel.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

class ControladorUsuario
{

    public static function listar()
    {

        $respuesta = UsuarioModel::listar();
        return $respuesta;
    }

}

if (isset($_POST["action"])) {

    $action = $_POST["action"];
    switch ($action) {
        case "insert":
            $hash = password_hash($_POST['contrasena'], PASSWORD_DEFAULT, ['cost' => 10]);
            $estado = true;
            UsuarioModel::agregar($_POST['nombre'], $_POST['usuario'], $_POST['rol_id'], $hash, $_POST['correo_recuperacion'], $estado);

            $mail = new PHPMailer(true);

            try {
                //Configuracion del Servidor
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                $mail->Username = 'puntodigital.soporte@gmail.com';                     //SMTP username
                $mail->Password = 'obhd gcbc uvag dojz';                               //SMTP password
                $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


                //Recipients
                $mail->setFrom('puntodigital.soporte@gmail.com', 'Punto Digital');
                $mail->addAddress($_POST['correo_recuperacion'], 'Usuario');
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Cuenta de usuario Punto Digital';
                $mail->Body = 'Se ha creado su cuenta de usuario para el sistema, por favor inicie sesion con las siguientes credenciales:
                usuario: ' . $_POST['usuario'] . '
                contraseña: ' . $_POST['contrasena'] . '
                Para iniciar sesion por favor haz clic en el siguiente enlace:
                      <a href="http://panf175.test/index.php">Iniciar sesion</a>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                session_start();
                $_SESSION['success_messageP'] = 'Usuario agregado exitosamente!, se ha enviado un correo para con las credenciales';
                header("Location: ../vistas/lista-usuario.php");

            } catch (Exception $e) {
                echo "El Correo no se pudo enviar por el siguiente error: {$mail->ErrorInfo}";
            }
            break;
        case "editar":
            UsuarioModel::editar($_POST);
            session_start();
            $_SESSION['info_messageP'] = 'Se ha editado el usuario';
            header("Location: ../vistas/lista-usuario.php");
            break;
        case "cambiarEstado":
            UsuarioModel::cambiarEstado($_POST);
            session_start();
            $_SESSION['info_messageP'] = 'Se ha cambiado el estado del usuario';
            header("Location: ../vistas/lista-usuario.php");
            break;
        case "borrar":
            UsuarioModel::borrar($_POST['id']);
            session_start();
            $_SESSION['info_messageP'] = 'Se ha borrado el usuario';
            header("Location: ../vistas/lista-usuario.php");
            break;

        default:
            echo "Bandera no encontrada";
            break;
    }

}