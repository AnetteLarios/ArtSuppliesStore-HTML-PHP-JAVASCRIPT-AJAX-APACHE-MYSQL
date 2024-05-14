<?php

require "conexionbd.php";
$con = conecta();
$id = $_REQUEST['id'];
if(isset($_POST["codigo"]) && isset($_POST["id"])) {
    $codigo = $_POST["codigo"];
    
    $sentencia = "SELECT codigo FROM productos WHERE productos.codigo = '$codigo' AND id != $id";
    $resultado = $con->query($sentencia);
    $existingCodes = $resultado->rowCount();

    if($existingCodes > 0){
        echo 'existing';
    }
}
