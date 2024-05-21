<?php
error_reporting(0);
require "funciones/conexionbd.php";

$con = conecta();

$id = $_REQUEST['id'];

$getProducts = $con->query("SELECT * FROM productos ORDER BY RAND() LIMIT 3"); 
$num_products  = $getProducts->rowCount();
$productos = $getProducts->fetchAll(PDO::FETCH_OBJ);

$sentencia = "SELECT productos.id, productos.nombre, productos.codigo, productos.descripcion, productos.costo, productos.stock, productos.archivo_f 
              FROM productos
              WHERE productos.id = $id";

$resultado = $con->query($sentencia);
$data = $resultado->fetchAll(PDO::FETCH_OBJ);

session_start();
$correoCliente = $_SESSION['correoCliente'];
$idCliente = $_SESSION['idCliente'];

function contarProductosCarrito($idCliente, $con) {
    $getRows = $con->prepare("SELECT COUNT(*) as total_productos FROM pedidos, pedidos_productos WHERE pedidos.id_cliente = ? AND pedidos_productos.id = pedidos.id AND pedidos.status=0");
    $getRows->execute([$idCliente]);
    $result = $getRows->fetch(PDO::FETCH_OBJ);
    return $result->total_productos;
}

$totalProductos = contarProductosCarrito($idCliente, $con);
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/product_details.css" type="text/css">
    <link rel="icon" href="images/justbackground.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <title>Diseñart</title>
    <script>
          $(document).ready(function() {
        function actualizarCarrito() {
            $.ajax({
                url: 'funciones/contar_productos_carrito.php',
                type: 'get',
                success: function(res) {
                    $('#cart_count').text(res);
                }
            });
        }
        // Llamar a la función para actualizar el número de productos al cargar la página
        actualizarCarrito();
    });
        function agregarCarrito(producto_id, stock, costo){
        var cantidad = $('#cantidad_' + producto_id).val();
        cantidad = parseInt(cantidad);

        if (cantidad > stock || cantidad <= 0) {
            alert("Cantidad inválida");
            return false;
        }

        $.ajax({
            url: 'funciones/agregaProducto.php',
            type: 'post',
            data: {
                producto_id: producto_id,
                stock: stock,
                costo: costo,
                deseados: cantidad
            },
            success: function(res){
                console.log(res); // Agregamos esta línea para depurar
                if (res == 1) {
                    $('#mensaje_' + producto_id).html('¡Añadido!');
                } else if (res == 2) {
                    $('#mensaje_' + producto_id).html('Añadido');
                } else {
                    $('#mensaje_' + producto_id).html('Error');
                }
                setTimeout(function() {
                    $('#mensaje_' + producto_id).html('');
                }, 5000);
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText); // Agregamos esta línea para depurar
                alert('Se ha producido un error: ' + error);
            }
        });
        }
    </script>
</head>
<body>
    <header id="navegation_bar">
        <a href="index.php">
            <img id="logo" src="images/diseñart.png" alt="logo">
        </a>
        <?php ?>
    <a class="link" id="home_link" href = "index.php">
        <p> Home</p>
    </a> 
    <a class="link" href = "productos.php">
        <p> Productos</p>
    </a>
    <a class="link" href = "contacto_formulario.php">
        <p> Contacto</p>
    </a>
    <?php
        if(empty($correoCliente)){
            echo "<a class='link'  href = '../Administración/index.php'>
                     <p> Iniciar Sesión </p>
                </a>";
        }else{
            echo "<a class='link'  href = 'carrito01.php'>
                    <p> Carrito(<span id='cart_count'>0</span>)</p>
                </a>";
        } 
    ?>
    <?php 
        if(!empty($correoCliente)){
            echo "<a class='link' href = 'funciones/cerrar_sesion.php'>
            <p> Cerrar Sesión</p>
        </a>";
        }
    ?>
    </header>
    <a class="regresar" href="productos.php">
        <div class="back_button">< Regresar</div>
    </a>
    <?php foreach($data as $producto) {
        $producto_id = $producto->id;
        $stock = $producto->stock;
        $costo = $producto->costo; ?>
        <div class="background_table">
            <div class="product_background">
                <div>
                    <img class="product_image" src="../Administración/product_files/<?php echo $producto->archivo_f?>">
                </div>
                <div>
                    <p class="title_product"><?php echo $producto->nombre?></p>
                    <p>Código: <?php echo $producto->codigo?></p>
                    <p>Descripción: <?php echo $producto->descripcion?></p>
                    <p>Stock: <?php echo $producto->stock?></p>
                    <p>$<?php echo $producto->costo?>.00</p>
                    <?php if(!empty($correoCliente)) { ?>
                        <input type="button" value="Añadir" class="addProductButton" onclick="agregarCarrito(<?php echo $producto_id; ?>, <?php echo $stock; ?>, <?php echo $costo; ?>);">
                        <label>
                            <input type="number" id="cantidad_<?php echo $producto_id; ?>" class="numberOfProducts" value="1" min="1" max="<?php echo $stock; ?>">
                        </label>
                        <div style="color:#233470;font-weight: bold;" id="mensaje_<?php echo $producto_id; ?>"></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <p class="other_products">Otros productos relacionados:</p>
    <div class="related_products">
        <?php foreach ($productos as $producto) { 
            $producto_id = $producto->id;
            $stock = $producto->stock;
            $costo = $producto->costo; ?>
            <div class="product" id="<?php echo $producto->id?>">
                <a href="producto_detalle.php?id=<?php echo $producto->id; ?>">
                    <img class="related_product_image" src="../Administración/product_files/<?php echo $producto->archivo_f; ?>">
                </a>
                <a href="producto_detalle.php?id=<?php echo $producto->id; ?>">
                    <p><?php echo $producto->nombre; ?></p>
                </a>
                <p><?php echo $producto->codigo; ?></p>
                <p>$<?php echo $producto->costo; ?>.00</p>
                <?php if(!empty($correoCliente)) { ?>
                    <input type="button" value="Añadir" class="addProductButton" onclick="agregarCarrito(<?php echo $producto_id; ?>, <?php echo $stock; ?>, <?php echo $costo; ?>);">
                        <label>
                            <input type="number" id="cantidad_<?php echo $producto_id; ?>" class="numberOfProducts" value="1" min="1" max="<?php echo $stock; ?>">
                        </label>
                    <div style="color:#233470;font-weight: bold;" id="mensaje_<?php echo $producto_id; ?>"></div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
