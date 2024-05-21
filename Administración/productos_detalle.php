<?php
error_reporting(0);
session_start();
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}
require "funciones/conexionbd.php";
$con = conecta();

$id = $_REQUEST['id'];

$sentencia = "SELECT productos.nombre, productos.codigo, productos.descripcion, productos.costo, productos.stock, productos.archivo_f, productos.status 
              FROM productos
              WHERE productos.id = $id";


$resultado = $con->query($sentencia);
$data = $resultado->fetchAll(PDO::FETCH_OBJ);
?>

<html lang="es">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Productos</title>
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel = "stylesheet" href = "css/detailsProduct.css" type="text/css">
    <link rel = "icon" href= "images/group.png">
    <!--<script src="js/jquery-3.3.1.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    </head>

    <body>
        <header id="navegation_bar">
            <a href="productos_lista.php">
                    <img id="employee_image" src="images/image1.png" alt = "employee">
            </a>
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

        </header>
        <div id="background_table">
            <div id="back_button">
            <a href = "productos_lista.php">< Regresar</a>
            </div>
            <div id="principal">
                <img id="employee" src="images/productos.png">
                <h3 id="title">Detalle Producto</h3>                
            </div>
            <div id="full_details_table">
                <div id="table_header">
                    <div class="header_field">Nombre</div>
                    <div class="header_field">Codigo</div>
                    <div class="header_field">Descripcion</div>
                    <div class="header_field">Costo</div>
                    <div class="header_field">Stock</div>
                    <div class="header_field">Status</div>
                    <div class="header_field">Imagen</div>
                </div>
                <?php foreach ($data as $dataProduct){
                    $estado = ($dataProduct->status == 1) ? 'Activo' : 'Inactivo'; ?>
                <div id="dataRow" >
                    <div class="dataCell"><?php echo $dataProduct->nombre?></div>
                    <div class="dataCell"><?php echo $dataProduct->codigo?></div>
                    <div class="dataCell"><?php echo $dataProduct->descripcion?></div>
                    <div class="dataCell"><?php echo $dataProduct->costo?></div>
                    <div class="dataCell"><?php echo $dataProduct->stock?></div>
                    <div class="dataCell"><?php echo $estado?></div>
                    <div class="dataCell"><?php echo "<img id='product_image' alt='product_image' src='product_files/{$dataProduct->archivo_f}'>"?></div>
                </div <?php }?>>
            </div>
        </div>
    </body>
</html>