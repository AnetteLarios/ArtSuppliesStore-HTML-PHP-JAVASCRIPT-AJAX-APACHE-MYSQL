<?php 
    session_start();
    $nombreCliente = $_SESSION['$nombreCliente'];
?>
    <a class="link" id="home_link" href = "../Usuarios/index.php">
        <p> Home</p>
    </a> 
    <a class="link" href = "../Usuarios/productos.php">
        <p> Productos</p>
    </a>
    <a class="link" href = "../Usuarios/contacto.php">
        <p> Contacto</p>
    </a>
    <?php

        if(empty($nombreCliente)){
            echo "<a class='link'  href = '../Administración/index.php'>
                     <p> Iniciar Sesión </p>
                </a>";
        }else{
            echo "<a class='link'  href = 'carrito01.php'>
                    <p> Carrito</p>
                </a>";

        } 
    ?>
    <?php 

        if(!empty($nombreCliente)){
            echo "<a class='link' href = 'funciones/cerrar_sesion.php'>
            <p> Cerrar Sesión</p>
        </a>";
        }
    ?>