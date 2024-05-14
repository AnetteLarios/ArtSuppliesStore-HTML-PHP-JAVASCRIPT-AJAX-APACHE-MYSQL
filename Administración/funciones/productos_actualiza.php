<?php

require "conexionbd.php";
$con = conecta();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET["id"]) || !isset($_POST["nombre"]) || !isset($_POST["codigo"]) || 
    !isset($_POST["descripcion"]) || !isset($_POST["costo"]) || !isset($_POST["stock"])) {
    exit();
}

$id = $_GET['id'];
$nombre  = $_POST["nombre"];
$codigo = $_POST["codigo"];
$descripcion = $_POST["descripcion"];
$costo = $_POST["costo"];
$stock = $_POST["stock"];

// Verificar si se ha cargado un nuevo archivo
if (!empty($_FILES["archivo_n"]["name"])) {
    $file_name = $_FILES['archivo_n']['name']; // nombre del archivo 
    $file_tmp = $_FILES['archivo_n']['tmp_name']; // nombre temporal del archivo
    $arreglo = explode(".", $file_name); // separa el nombre para obtener la extensión
    $len = count($arreglo); // número de elementos
    $pos = $len - 1; // posición a buscar
    $ext = $arreglo[$pos]; // extensión
    $dir = "../product_files/"; // carpeta donde se guardan los archivos
    $file_enc = md5_file($file_tmp); // nombre del archivo encriptado

    $fileName1 = "$file_enc.$ext";
    
    // Copiar el nuevo archivo
    if (move_uploaded_file($file_tmp, $dir . $fileName1)) {
        echo "El archivo se ha subido correctamente. Nombre del archivo: $fileName1 <br>";
    } else {
        die("Error al subir el archivo.");
    }
} else {
    // Si no se cargó un nuevo archivo, mantener el archivo existente
    $sentencia = "SELECT archivo_n, archivo_f FROM productos WHERE id = $id";
    $resultado = $con->query($sentencia);
    $row = $resultado->fetch(PDO::FETCH_ASSOC);
    $fileName1 = $row['archivo_f'];
}

$status = 1;

// Preparar y ejecutar la actualización
$update = $con->prepare("UPDATE productos SET nombre = ?, codigo = ?, descripcion = ?, costo = ?, stock = ?, archivo_n = ?, archivo_f = ?, status = ? WHERE id = ?");
$update->bindValue(1, $nombre);
$update->bindValue(2, $codigo);
$update->bindValue(3, $descripcion);
$update->bindValue(4, $costo);
$update->bindValue(5, $stock);
$update->bindValue(6, $fileName1);
$update->bindValue(7, $fileName1);
$update->bindValue(8, $status);
$update->bindValue(9, $id);

if ($update->execute()) {
    header("Location: ../productos_lista.php");
    exit();
} else {
    die("Error al actualizar el empleado: " . $update->error);
}
