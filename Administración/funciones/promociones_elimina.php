<?php

require "conexionbd.php";
$con = conecta();
$rowId = $_REQUEST['rowId'];

$sentencia = "UPDATE promociones SET eliminado = 1 WHERE id = $rowId";
$resultado = $con->query($sentencia);  
echo 1;
?>