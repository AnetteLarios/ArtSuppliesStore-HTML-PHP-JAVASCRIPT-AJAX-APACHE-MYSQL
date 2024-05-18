<?php

require "funciones/conexionbd.php";

$con = conecta();

$id = $_REQUEST['id'];

$getProducts = $con->query("SELECT * FROM productos ORDER BY RAND() LIMIT 3"); 
$num_products  = $getProducts->rowCount();
$productos = $getProducts->fetchAll(PDO::FETCH_OBJ);

$sentencia = "SELECT productos.nombre, productos.codigo, productos.descripcion, productos.costo, productos.stock, productos.archivo_f 
              FROM productos
              WHERE productos.id = $id";


$resultado = $con->query($sentencia);
$data = $resultado->fetchAll(PDO::FETCH_OBJ);

session_start();
$nombreClient = $_SESSION['nombreCliente'];
?>

<html lang = es>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel="stylesheet" href="css/product_details.css" type="text/css">
        <link rel="icon" href="images/justbackground.png">
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <title>Diseñart</title>
    </head>
    <body>
        <header id="navegation_bar">
            <a href="index.php">
                        <img id="logo" src="images/diseñart.png" alt = "logo">
            </a>
            <?php
                include('menu.php');
            ?>
        </header>
        <a class="regresar" href="productos.php">
            <div class="back_button">< Regresar</div>
        </a>
        <?php foreach($data as $producto){ ?>
            <div class="background_table">
                <div class="product_background">
                    <div>
                        <img class="product_image" src="../Administración/product_files/<?php echo $producto->archivo_f?>">
                    </div>
                    <div>
                    <p class="title_product" ><?php echo $producto->nombre?></p>
                    <p>Código: <?php echo $producto->codigo?></p>
                    <p>Descripción: <?php echo $producto->descripcion?></p>
                    <p>$<?php echo $producto->costo?>.00</p>
                    <?php
                    if(!empty($nombreCliente)){
                        echo "
                        <input type='button' value='Añadir' class='addProductButton'></input>
                        <label>
                            <input name='odf' type='number' class='numberOfProducts'></input>
                        </label>";
                    }
                    ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <p class="other_products">Otros productos relacionados:</p>
        <div class="related_products">
            <?php foreach ($productos as $producto){?>
                <div class="product">
                    <a href="producto_detalle.php?id=<?php echo $producto->id?>">
                        <img class="related_product_image" src="../Administración/product_files/<?php echo $producto->archivo_f?>">
                    </a>
                    <a href="producto_detalle.php?id=<?php echo $producto->id?>">
                        <p><?php echo $producto->nombre?></p>
                    </a> 
                    <p><?php echo $producto->codigo?></p>
                    <p>$<?php echo $producto->costo?>.00</p>
                    <?php
                        if(!empty($nombreCliente)){
                            echo "
                            <input type='button' value='Añadir' class='addProductButton'></input>
                            <label>
                                <input name='odf' type='number' class='numberOfProducts'></input>
                            </label>";
                        }
                    ?>
                </div>
            <?php }?>
        </div>
        <footer>
            <?php
                include ('footer.php'); 
            ?>
        </footer>
    </body>
</html>