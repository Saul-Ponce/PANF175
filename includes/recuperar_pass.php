<?php
include '../models/conexion.php';
$con = connection();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../PHPMailer/Exception.php';
include '../PHPMailer/PHPMailer.php';
include '../PHPMailer/SMTP.php';
$correo = $_POST['correo'];
$verificar_correo = "SELECT count(1) FROM usuarios WHERE correo_recuperacion = '$correo'";
$obtener_id = "SELECT id FROM usuarios WHERE correo_recuperacion = '$correo'";
$ejecutar = mysqli_query($con, $verificar_correo);
$fila = mysqli_fetch_row($ejecutar);
if ($fila[0] > 0) {
    $ejecutar = mysqli_query($con, $obtener_id);
    $fila = mysqli_fetch_row($ejecutar);
    $mail = new PHPMailer(true);

    try {
        //Configuracion del Servidor
        $mail->isSMTP();
        $mail->Host = 'smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'activapc2022vostro@outlook.es';
        $mail->Password = 'Activa2022';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar TLS
        $mail->Port = 587; // Usar el puerto 587 para TLS
        $mail->SMTPDebug = 2; // Muestra información detallada sobre el envío
        $mail->Debugoutput = 'html'; // Para ver la salida en formato HTML

        //Recipients
        $mail->setFrom('activapc2022vostro@outlook.es', 'Punto Digital');
        $mail->addAddress($correo, 'Usuario');
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Cambio de contraseña';
        $mail->Body = 'Para cambiar tu contraseña por favor haz clic en el siguiente enlace:
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