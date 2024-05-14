<?php

require "conexionbd.php";
$con = conecta();

if(isset($_POST["codigo"])) {
    $codigo = $_POST["codigo"];
    
    $sentencia = "SELECT codigo FROM productos WHERE productos.codigo = '$codigo';";
    $resultado = $con->query($sentencia);
    $existingCodes = $resultado->rowCount();

    if($existingCodes > 0){
        echo 'existing';
    }
}
