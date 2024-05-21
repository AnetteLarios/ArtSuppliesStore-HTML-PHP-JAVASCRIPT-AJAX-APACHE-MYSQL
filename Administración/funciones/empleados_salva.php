<?php

require "conexionbd.php";
$con = conecta();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST["nombre"]) || !isset($_POST["apellidos"]) || !isset($_POST["correo"]) || 
    !isset($_POST["pass"]) ||! isset($_POST["id_rol"]) || !isset($_FILES['archivo_n'])) exit();

$file_name = $_FILES['archivo_n']['name']; //nombre del archivo 
$file_tmp = $_FILES['archivo_n']['tmp_name']; //nombre temporal del archivo
$arreglo = explode(".", $file_name); //separa el nombre para obtener la extension
$len = count($arreglo);//numero de elementos
$pos = $len-1;//posicion a uscar
$ext = $arreglo[$pos]; //extension
$dir = "user_files/"; //carpeta donde se guardan los archivos
$file_enc = md5_file($file_tmp); //nombre del archivo encriptado

if($file_name != ''){
    $fileName1 = "$file_enc.$ext";
    copy($file_tmp, $dir.$fileName1);
    echo " filename: $fileName1 <br>";
}

$nombre  = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$correo = $_POST["correo"];
$pass = $_POST["pass"];
$passEnc = md5($pass);
$id_rol = $_POST["id_rol"];
$archivo_n = $file_name;
$archivo_f = $fileName1;
$status = 1;


$insert = $con->prepare("INSERT INTO empleados (nombre, apellidos, correo, pass, id_rol, archivo_n, archivo_f, status) VALUES (?,?,?,?,?,?,?,?)");
    if (!$insert) {
        die("Error en la preparación de la sentencia: " . $con->error);
    }
    $resultado = $insert->execute([$nombre, $apellidos, $correo, $passEnc, $id_rol, $archivo_n, $archivo_f, $status]);
        
    if($resultado === TRUE){
        header("Location: ../empleados_lista.php");
    }else echo "No se puedo añadir el usuario, por favor intente de nuevo";
    