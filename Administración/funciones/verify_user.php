<?php
require "conexionbd.php";
session_start();
$con = conecta();

$correo = isset($_POST['correo']) ? $_POST['correo'] : null;
$pass = isset($_POST['pass']) ? $_POST['pass'] : null;

$response = array(); // Inicializamos la respuesta como un array vacío

if ($correo && $pass) {
    // Encriptar la contraseña con MD5
    $passEnc = md5($pass);

    // Verificar si es empleado
    $stmt = $con->prepare("SELECT * FROM empleados WHERE correo = :correo AND pass = :passEnc AND status = 1 AND eliminado = 0");
    $stmt->execute(array(':correo' => $correo, ':passEnc' => $passEnc));
    if ($stmt->rowCount() > 0) {
        // Credenciales correctas para empleado
        $response['type'] = "admin";
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['tipoUsuario'] = "admin"; 
        $_SESSION['idUser'] = $row['id']; 
        $_SESSION['nombreUser'] = $row["nombre"]. ' '. $row["apellidos"];
        $_SESSION['soloNombreUser'] = $row["nombre"];
        $_SESSION['correoUser'] = $row['correo'];
        echo json_encode($response);
        exit;
    }

    // Verificar si es cliente
    $stmt = $con->prepare("SELECT * FROM clientes WHERE correo = :correo AND pass = :passEnc AND status = 1 AND eliminado = 0");
    $stmt->execute(array(':correo' => $correo, ':passEnc' => $passEnc));
    if ($stmt->rowCount() > 0) {
        // Credenciales correctas para cliente
        $response['type'] = "cliente";
        $_SESSION['tipoUsuario'] = "cliente"; 
        $_SESSION['idCliente'] = $row['id']; 
        $_SESSION['nombreCliente'] = $row["nombre"]. ' '. $row["apellidos"];
        $_SESSION['soloNombreCliente'] = $row["nombre"];
        $_SESSION['correoCliente'] = $row['correo'];// Opcional: Guardar tipo de usuario en sesión
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
