<?php
include '../models/conexion.php';
$con = connection();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../PHPMailer/Exception.php';
include '../PHPMailer/PHPMailer.php';
include '../PHPMailer/SMTP.php';
$correo = $_POST['correo_recuperacion'];
$verificar_correo = "SELECT count(1) FROM usuarios WHERE correo_recuperacion = '$correo'";
$obtener_usuario = "SELECT usuario FROM usuarios WHERE correo_recuperacion = '$correo'";
$ejecutar = mysqli_query($con, $verificar_correo);
$fila = mysqli_fetch_row($ejecutar);
if ($fila[0] > 0) {
    $ejecutar = mysqli_query($con, $obtener_usuario);
    $fila = mysqli_fetch_row($ejecutar);
    $mail = new PHPMailer(true);

    // Clave secreta para firmar el token (debe mantenerse segura)
    $clave_secreta = bin2hex(random_bytes(32));
    session_start();
    $_SESSION["clave"] = $clave_secreta;

    // Información del usuario (por ejemplo, su ID o correo)
    $usuario = $fila[0];

    // Tiempo de expiración (1 hora en este ejemplo)
    $expiracion = time() + 3600;

    // Crear el payload
    $payload = [
        'usuario' => $usuario,
        'exp' => $expiracion
    ];

    // Convertir el payload a JSON y luego codificarlo en base64
    $payload_base64 = base64_encode(json_encode($payload));

    // Crear una firma con hash_hmac usando SHA256
    $firma = hash_hmac('sha256', $payload_base64, $clave_secreta);

    // Combina el payload y la firma para formar el token final
    $token = $payload_base64 . '.' . $firma;

    try {
        //Configuracion del Servidor
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'puntodigital.soporte@gmail.com';                     //SMTP username
        $mail->Password = 'obhd gcbc uvag dojz';                               //SMTP password
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('puntodigital.soporte@gmail.com', 'Punto Digital');
        $mail->addAddress($correo, $correo);
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recuperacion de contraseña';
        $mail->Body = 'Para cambiar tu contraseña por favor haz clic en el siguiente enlace:
                      <a href="http://panf175.test/vistas/cambiar_contra.php?token=' . $token . '">Recuperacion de Contraseña</a>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo json_encode(array("exito" => "Se ha enviado un correo para recuperar su contraseña"));
    } catch (Exception $e) {
        echo json_encode(array("error" => "El Correo no se pudo enviar por el siguiente error: {$mail->ErrorInfo}"));
    }
} else {
    echo json_encode(array("error" => "Este correo no ha sido registrado en nuestro sistema!!!"));
}