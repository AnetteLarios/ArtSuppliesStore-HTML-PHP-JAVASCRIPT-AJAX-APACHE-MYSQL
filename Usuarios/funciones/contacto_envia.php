<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
$apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
$comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_STRING);
$subject = "Comentario enviado por $correo en diseñart";

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'codingrepositories@gmail.com';
    $mail->Password = 'nful ngde ylcf jbcz';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
   
    $mail->setFrom('codingrepositories@gmail.com');
    $mail->addAddress($correo);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $comentario;
    $mail->send();

    echo "Correo enviado correctamente";

    // Resto de la configuración del correo...
} catch (Exception $e) {
    echo "No se pudo enviar el mensaje. Error del Mailer: {$mail->ErrorInfo}";
}
