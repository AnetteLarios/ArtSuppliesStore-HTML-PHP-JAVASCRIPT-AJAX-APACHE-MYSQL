<?php
    require "funciones/conexionbd.php";

    $con = conecta();

    $getProducts = $con->query("SELECT * FROM productos ORDER BY RAND() LIMIT 6"); 
    $num_products  = $getProducts->rowCount();
    $productos = $getProducts->fetchAll(PDO::FETCH_OBJ);

    $getPromotion = $con->query("SELECT * FROM promociones ORDER BY RAND() LIMIT 1");
    $num_promotions = $getPromotion->rowCount();
    $promocion = $getPromotion->fetchAll(PDO::FETCH_OBJ);

    session_start();
    $nombreCliente = $_SESSION['nombreCliente'];

?>


<html lang = es>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel="stylesheet" href="css/usersIndexCss.css" type="text/css">
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
        <?php foreach($promocion as $promo) { ?>
        <div id="promotion_container">
            <img id="promotion" src="../Administración/promotion_files/<?php echo $promo->archivo;?>" alt="promocion">
            <?php }?>
        </div>
        <div id="background_table">
            <?php foreach($productos as $producto) { ?>
                <div class="product" id="<?php echo $producto->id?>">
                    <a href="producto_detalle.php?id=<?php echo $producto->id?>">
                        <img src="../Administración/product_files/<?php echo $producto->archivo_f?>">
                    </a>
                    <a href="producto_detalle.php?id=<?php echo $producto->id?>">
                        <p><?php echo $producto->nombre?></p>
                    </a> 
                    <p>Código:<?php echo $producto->codigo?></p>
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