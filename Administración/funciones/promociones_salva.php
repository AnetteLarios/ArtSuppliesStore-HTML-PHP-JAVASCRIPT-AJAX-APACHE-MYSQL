<?php

require "conexionbd.php";
$con = conecta();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST["nombre"]) || !isset($_FILES['archivo'])) exit();

$file_name = $_FILES['archivo']['name']; //nombre del archivo 
$file_tmp = $_FILES['archivo']['tmp_name']; //nombre temporal del archivo
$arreglo = explode(".", $file_name); //separa el nombre para obtener la extension
$len = count($arreglo);//numero de elementos
$pos = $len-1;//posicion a uscar
$ext = $arreglo[$pos]; //extension
$dir = "../promotion_files/"; //carpeta donde se guardan los archivos
$file_enc = md5_file($file_tmp); //nombre del archivo encriptado

if($file_name != ''){
    $fileName1 = "$file_enc.$ext";
    copy($file_tmp, $dir.$fileName1);
    echo " filename: $fileName1 <br>";
}

$nombre  = $_POST["nombre"];
$archivo = $fileName1;
$status = 1;


$insert = $con->prepare("INSERT INTO promociones (nombre, archivo, status) VALUES (?,?,?)");
    if (!$insert) {
        die("Error en la preparación de la sentencia: " . $con->error);
    }
    $resultado = $insert->execute([$nombre, $archivo, $status]);
        
    if($resultado === TRUE){
        header("Location: ../promociones_lista.php");
    }else echo "No se puedo añadir la promocion, por favor intente de nuevo";
    