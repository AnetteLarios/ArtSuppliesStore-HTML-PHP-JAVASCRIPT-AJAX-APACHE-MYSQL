<?php
error_reporting(0);
require "conexionbd.php";
$con = conecta();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST["nombre"]) || !isset($_POST["codigo"]) || !isset($_POST["descripcion"]) || 
    !isset($_POST["costo"]) ||! isset($_POST["stock"]) || !isset($_FILES['archivo_n'])) exit();

$file_name = $_FILES['archivo_n']['name']; //nombre del archivo 
$file_tmp = $_FILES['archivo_n']['tmp_name']; //nombre temporal del archivo
$arreglo = explode(".", $file_name); //separa el nombre para obtener la extension
$len = count($arreglo);//numero de elementos
$pos = $len-1;//posicion a uscar
$ext = $arreglo[$pos]; //extension
$dir = "../product_files/"; //carpeta donde se guardan los archivos
$file_enc = md5_file($file_tmp); //nombre del archivo encriptado

if($file_name != ''){
    $fileName1 = "$file_enc.$ext";
    copy($file_tmp, $dir.$fileName1);
    echo " filename: $fileName1 <br>";
}

$nombre  = $_POST["nombre"];
$codigo = $_POST["codigo"];
$descripcion = $_POST["descripcion"];
$costo = $_POST["costo"];
$stock = $_POST["stock"];
$archivo_n = $file_name;
$archivo_f = $fileName1;
$status = 1;


$insert = $con->prepare("INSERT INTO productos (nombre, codigo, descripcion, costo, stock, archivo_n, archivo_f, status) VALUES (?,?,?,?,?,?,?,?)");
    if (!$insert) {
        die("Error en la preparación de la sentencia: " . $con->error);
    }
    $resultado = $insert->execute([$nombre, $codigo, $descripcion, $costo, $stock, $archivo_n, $archivo_f, $status]);
        
    if($resultado === TRUE){
        header("Location: ../productos_lista.php");
    }else echo "No se puedo añadir el usuario, por favor intente de nuevo";
    