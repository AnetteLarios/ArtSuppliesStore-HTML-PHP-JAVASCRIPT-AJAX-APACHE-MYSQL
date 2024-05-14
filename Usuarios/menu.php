<?php 
session_start();
$nombre = $_SESSION['soloNombreUser'];
?>
    <a class="link" href = "bienvenido.php">
        <p> Home</p>
    </a> 
    <a class="link" href = "empleados_lista.php">
        <p> Productos</p>
    </a>
    <a class="link" href = "productos_lista.php">
        <p> Contacto</p>
    </a>
    <a class="link"  href = "promociones_lista.php">
        <p> Carrito</p>
    </a>
