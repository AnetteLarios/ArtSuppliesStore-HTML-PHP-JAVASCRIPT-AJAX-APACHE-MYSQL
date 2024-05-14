<?php

require "conexionbd.php";
$con = conecta();
$id = $_REQUEST['id'];
if(isset($_POST["correo"]) && isset($_POST["id"])) {
    $correo = $_POST["correo"];
    
    $sentencia = "SELECT correo FROM empleados WHERE empleados.correo = '$correo' AND id != $id";
    $resultado = $con->query($sentencia);
    $existingEmails = $resultado->rowCount();

    if($existingEmails > 0){
        echo 'existing';
    }
}
