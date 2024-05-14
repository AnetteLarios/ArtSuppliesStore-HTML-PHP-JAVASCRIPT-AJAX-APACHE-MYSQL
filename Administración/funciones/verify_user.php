<?php
require "conexionbd.php";
session_start();
$con = conecta();

$correo = $_POST['correo'];
$pass = $_POST['pass'];
$passEnc = md5($pass);

$response = array(); // Creamos un array para la respuesta

if (isset($correo) && isset($pass)) {
    $stmt = $con->prepare("SELECT * FROM empleados WHERE correo = :correo AND pass = :passEnc AND status = 1 AND eliminado = 0");
    $stmt->execute(array(':correo' => $correo, ':passEnc' => $passEnc));
    $rows = $stmt->rowCount();

    if ($rows > 0) {
        // Credenciales correctas
        $response['success'] = true;
        $response['message'] = "Inicio de sesión exitoso";
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row["id"];
        $nombre = $row["nombre"]. ' '. $row["apellidos"];
        $solonombre = $row["nombre"];
        $correo = $row["correo"];

        $_SESSION['idUser'] = $id;
        $_SESSION['nombreUser'] = $nombre;
        $_SESSION['soloNombreUser'] = $solonombre;
        $_SESSION['correoUser'] = $correo;
    
    } else {
        // Credenciales incorrectas
        $response['success'] = false;
        $response['message'] = "El usuario no existe o las credenciales son incorrectas";
    }
}

// Devolvemos la respuesta como un objeto JSON
echo json_encode($response);
?>
