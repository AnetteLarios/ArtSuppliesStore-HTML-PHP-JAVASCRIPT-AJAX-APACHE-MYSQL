<?php

require "conexionbd.php";
$con = conecta();
$id = $_REQUEST['id'];
if(isset($_POST["nombre"]) && isset($_POST["id"])) {
    $nombre = $_POST["nombre"];
    
    $sentencia = "SELECT nombre FROM promociones WHERE promociones.nombre = '$nombre' AND id != $id";
    $resultado = $con->query($sentencia);
    $existingNames = $resultado->rowCount();

    if($existingNames > 0){
        echo 'existing';
    }
}
