<?php
require "conexionbd.php";
session_start();
$con = conecta();

$correo = isset($_POST['correo']) ? $_POST['correo'] : null;
$pass = isset($_POST['pass']) ? $_POST['pass'] : null;

$response = array(); // Inicializamos la respuesta como un array vacío

if ($correo && $pass) {
    $passEnc = md5($pass); // Encriptar la contraseña con MD5 (no recomendado para producción, usa password_hash en su lugar)

    // Verificar si es empleado
    $stmt = $con->prepare("SELECT * FROM empleados WHERE correo = :correo AND pass = :passEnc AND status = 1 AND eliminado = 0");
    $stmt->execute(array(':correo' => $correo, ':passEnc' => $passEnc));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        // Credenciales correctas para empleado
        $_SESSION['tipoUsuario'] = "admin";
        $_SESSION['idUser'] = $row['id'];
        $_SESSION['nombreUser'] = $row["nombre"] . ' ' . $row["apellidos"];
        $_SESSION['soloNombreUser'] = $row["nombre"];
        $_SESSION['correoUser'] = $row['correo'];
        $response['type'] = "admin";
        echo json_encode($response);
        exit;
    }

    // Verificar si es cliente
    $stmt = $con->prepare("SELECT * FROM clientes WHERE correo = :correo AND pass = :passEnc AND status = 1 AND eliminado = 0");
    $stmt->execute(array(':correo' => $correo, ':passEnc' => $passEnc));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        // Credenciales correctas para cliente
        $_SESSION['tipoUsuario'] = "cliente";
        $_SESSION['idCliente'] = $row['id'];
        $_SESSION['nombreCliente'] = $row["nombre"] . ' ' . $row["apellidos"];
        $_SESSION['soloNombreCliente'] = $row["nombre"];
        $_SESSION['correoCliente'] = $row['correo'];
        $response['type'] = "cliente";
        echo json_encode($response);
        exit;
    }

    // Credenciales incorrectas
    $response['message'] = "Correo y/o contraseña incorrectos";
} else {
    // Datos no especificados
    $response['message'] = "Correo y/o contraseña no especificados";
}

// Devolvemos la respuesta como un objeto JSON
echo json_encode($response);
?>
