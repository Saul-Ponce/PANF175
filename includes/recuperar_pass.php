<?php
include "conexion.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
$correo = $_POST['correo'];
$verificar_correo = "SELECT count(1) FROM usuario WHERE correo = '$correo'";
$obtener_id = "SELECT id_usuario FROM usuario WHERE correo = '$correo'";
$ejecutar = mysqli_query($conexion, $verificar_correo);
$fila = mysqli_fetch_row($ejecutar);
if ($fila[0] > 0) {
    $ejecutar = mysqli_query($conexion, $obtener_id);
    $fila = mysqli_fetch_row($ejecutar);
    $mail = new PHPMailer(true);

    try {
        //Configuracion del Servidor
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'activapc2022vostro@outlook.es';                     //SMTP username
        $mail->Password = 'Activa2022';                               //SMTP password
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('activapc2022vostro@outlook.es', 'Punto Digital');
        $mail->addAddress($correo, 'Usuario');
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recuperacion de Cuenta';
        $mail->Body = 'Para recuperar tu contraseña por favor haz clic en el siguiente enlace:
                      <a href="localhost/PD/vistas/cambiar_contra.php?id=' . $fila[0] . '">Recuperacion de Contraseña</a>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo '
        <script>
           alert("El correo de recuperacion se ha enviado con exito!!!");
           window.location = "../index.html"
           </script>
    ';
    } catch (Exception $e) {
        echo "El Correo no se pudo enviar por el siguiente error: {$mail->ErrorInfo}";
    }
    //     echo '
    //     <script>
    //     alert("Correo Existe!!!");
    //     window.location = "../vistas/recuperar_pass.html"
    //     </script>
    // ';
} else {
    echo '
        <script>
        alert("Este correo no ha sido registrado en nuestro sistema!!!");
        window.location = "../vistas/recuperar_pass.html"
        </script>
    ';
}
?>