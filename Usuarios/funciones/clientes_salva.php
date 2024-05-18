<?php

require "conexionbd.php";
$con = conecta();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST["nombre"]) || !isset($_POST["apellidos"]) || !isset($_POST["correo"]) || 
    !isset($_POST["pass"])) exit();



$nombre  = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$correo = $_POST["correo"];
$pass = $_POST["pass"];
$passEnc = md5($pass);
$status = 1;


$insert = $con->prepare("INSERT INTO clientes (nombre, apellidos, correo, pass, status) VALUES (?,?,?,?,?)");
    if (!$insert) {
        die("Error en la preparación de la sentencia: " . $con->error);
    }
    $resultado = $insert->execute([$nombre, $apellidos, $correo, $passEnc, $status]);
        
    if($resultado === TRUE){
        header("Location: ../../Administración/index.php");
    }else echo "No se puedo añadir el cliente, por favor intente de nuevo";
    