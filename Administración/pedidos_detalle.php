<?php
session_start();
error_reporting(0);
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}
require "funciones/conexionbd.php";
$con = conecta();

$id = $_REQUEST['id'];

// Corrección de la consulta SQL
$sentencia = ("SELECT pedidos_productos.id, pedidos_productos.id_producto, productos.nombre, pedidos_productos.cantidad, pedidos_productos.precio
              FROM pedidos_productos
              INNER JOIN productos ON pedidos_productos.id_producto = productos.id
              WHERE pedidos_productos.id = $id");

$resultado = $con->query($sentencia);
$data = $resultado->fetchAll(PDO::FETCH_OBJ);
$total = 0;
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle pedidos_productos</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/detailsOrder.css" type="text/css">
    <link rel="icon" href="images/group.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
</head>

<body>
    <header id="navegation_bar">
        <a href="bienvenida.php">
            <img id="employee_image" src="images/image1.png" alt="employee">
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
            <a href="pedidos_lista.php">&lt; Regresar</a>
        </div>
        <div id="principal">
            <img id="employee" src="images/pedidos.png">
            <h3 id="title">Detalle Pedido</h3>
        </div>
        <div id="full_details_table">
            <div id="table_header">
                <div class="header_field">ID Producto</div>
                <div class="header_field">Nombre</div>
                <div class="header_field">Cantidad</div>
                <div class="header_field">Precio</div>
                <div class="header_field">Subtotal</div>
            </div>
            <?php foreach ($data as $dataProduct) {
                // Actualización del total
                $precio = $dataProduct->precio;
                $cantidad = $dataProduct->cantidad;
                $subtotal = $cantidad * $precio;
                $total += $subtotal; ?>
                
                <div id="dataRow">
                    <div class="dataCell"><?php echo $dataProduct->id_producto ?></div>
                    <div class="dataCell"><?php echo $dataProduct->nombre ?></div>
                    <div class="dataCell"><?php echo $dataProduct->cantidad ?></div>
                    <div class="dataCell">$<?php echo $dataProduct->precio ?>.00</div>
                    <div class="dataCell">$<?php echo $subtotal?>.00</div>
                </div>
            <?php } ?>
            <!-- Fila de total -->
            <div id="dataRow">
                <div class="dataCell"></div>
                <div class="dataCell"></div>
                <div class="dataCell"></div>
                <div class="dataCell"><b>Total:</b></div>
                <div class="dataCell"><b>$<?php echo $total ?>.00 </b></div>
            </div>
        </div>
    </div>
</body>
</html>
