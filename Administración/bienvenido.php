<?php
session_start();
error_reporting(0);
$nombre = $_SESSION['soloNombreUser'];

/*
$inactive_time = 300;

$session_life = time() - $_SESSION['nombreUser'];
if($session_life > $inactive_time){
    session_destroy(); 
    header('Location : index.php');
}
$_SESSION['timeout']=time();
*/
if(empty($nombre)){
    header("Location: index.php");
}
?>
<html lang="es">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Bienvenido</title>
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel = "stylesheet" href = "css/bienvenido.css" type="text/css">
        <link rel = "icon" href= "images/image1.png">
        <!--<script src="js/jquery-3.3.1.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    </head>
    <body>
        <nav id="navegation_bar">
            <img id="employee_image" src="images/image1.png" alt = "employee">
            <p>Panel de administrador |</p>
            <?php 
?>
    <a class="link" href = "bienvenido.php">
        <p> Inicio</p>
    </a> 
    <a class="link" href = "empleados_lista.php">
        <p> Empleados</p>
    </a>
    <a class="link" href = "productos_lista.php">
        <p> Productos</p>
    </a>
    <a class="link"  href = "promociones_lista.php">
        <p> Promociones</p>
    </a>
    <a class="link"  href = "bienvenido.php">
        <p>Bienvenido <?php echo $nombre?></p>
    </a>
    <a class="link" href = "pedidos_lista.php">
        <p> Pedidos</p>
    </a>
    <a class="link" href = "funciones/cerrar_sesion.php" style="width: 120px;">
        <p>Cerrar sesión</p>
    </a>

        </nav>
        <div id="background">
            <div id="principal">
                <h3 id="title">¡Bienvenido <?php echo $nombre;?> al sistema de administración!</h3>                
            </div>
        </div>
    </body>
</html>