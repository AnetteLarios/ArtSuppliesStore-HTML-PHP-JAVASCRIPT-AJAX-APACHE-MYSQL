<?php

require "conexionbd.php";
$con = conecta();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET["id"]) || !isset($_POST["nombre"])) {
    exit();
}

$id = $_GET['id'];
$nombre  = $_POST["nombre"];


// Verificar si se ha cargado un nuevo archivo
if (!empty($_FILES["archivo"]["name"])) {


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

    // Copiar el nuevo archivo
    if (move_uploaded_file($file_tmp, $dir . $fileName1)) {
        echo "El archivo se ha subido correctamente. Nombre del archivo: $fileName1 <br>";
    } else {
        die("Error al subir el archivo.");
    }
} else {
    // Si no se cargó un nuevo archivo, mantener el archivo existente
    $sentencia = "SELECT archivo FROM promociones WHERE id = $id";
    $resultado = $con->query($sentencia);
    $row = $resultado->fetch(PDO::FETCH_ASSOC);
    $fileName1 = $row['archivo'];
}

$status = 1;

// Preparar y ejecutar la actualización
$update = $con->prepare("UPDATE promociones SET nombre = ?, archivo = ?, status = ? WHERE id = ?");
$update->bindValue(1, $nombre);
$update->bindValue(2, $fileName1);
$update->bindValue(3, $status);
$update->bindValue(4, $id);

if ($update->execute()) {
    header("Location: ../promociones_lista.php");
    exit();
} else {
    die("Error al actualizar la promocion: " . $update->error);
}
