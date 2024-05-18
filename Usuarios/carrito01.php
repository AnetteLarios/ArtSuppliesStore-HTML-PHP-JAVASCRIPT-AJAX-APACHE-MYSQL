<?php
session_start();
$nombreCliente = $_SESSION['nombreCliente'];

if(empty($nombreCliente)){
    header("Location: ../Administración/index.php");
}
?>