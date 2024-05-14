<?php

require "conexionbd.php";
$con = conecta();

if(isset($_POST["nombre"])) {
    $nombre = $_POST["nombre"];
    
    $sentencia = "SELECT nombre FROM promociones WHERE promociones.nombre = '$nombre';";
    $resultado = $con->query($sentencia);
    $existingNames = $resultado->rowCount();

    if($existingNames > 0){
        echo 'existing';
    }
}
