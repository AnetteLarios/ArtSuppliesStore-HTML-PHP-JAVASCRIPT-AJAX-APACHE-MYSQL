<?php
session_start();

$nombre = $_SESSION['nombreUser'];

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
                include('menu.php');
            ?>
        </nav>
        <div id="background">
            <div id="principal">
                <h3 id="title">¡Bienvenido <?php echo $nombre;?> al sistema de administración!</h3>                
            </div>
        </div>
    </body>
</html>