<?php
$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
$apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
$comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_STRING);
$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);

if (!empty($nombre) && !empty($apellidos) && !empty($comentario) && !empty($correo)) {
    $destino = 'codingrepositories@gmail.com';
    $asunto = "¡$correo ha enviado un comentario mediante diseñart!";
    $cuerpo = '
    <html>
        <head>
            <title>Comentario en diseñart</title>
        </head>
        <body>
            <h1>Email de: '.$nombre.' </h1>
            <p>Usuario: '.$correo.'</p>
            <p> '.$comentario.'</p>
        </body>
    </html>
    ';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $headers .= "From: Diseñart <$correo>\r\n";
    $headers .= "Return-path: $destino\r\n";

    if (mail($destino, $asunto, $cuerpo, $headers)) {
        echo "Comentario enviado correctamente";
    } else {
        echo "Error al enviar el correo";
    }
} else {
    echo "Error: Todos los campos son obligatorios";
}
?>
