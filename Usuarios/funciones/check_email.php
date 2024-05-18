<?php

require "conexionbd.php";
$con = conecta();

if(isset($_POST["correo"])) {
    $correo = $_POST["correo"];
    
    $sentencia = "SELECT correo FROM clientes WHERE clientes.correo = '$correo';";
    $resultado = $con->query($sentencia);
    $existingEmails = $resultado->rowCount();

    if($existingEmails > 0){
        echo 'existing';
    }
}
