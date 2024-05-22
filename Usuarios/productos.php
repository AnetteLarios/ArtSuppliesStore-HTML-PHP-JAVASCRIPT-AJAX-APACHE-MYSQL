<?php
require_once "funciones/conexionbd.php";

error_reporting(0);
$con = conecta();

$getProducts = $con->query("SELECT * FROM productos WHERE status = 1 AND eliminado = 0 ORDER BY RAND() LIMIT 29"); 
$num_products = $getProducts->rowCount();
$productos = $getProducts->fetchAll(PDO::FETCH_OBJ);

session_start();
$correoCliente = $_SESSION['correoCliente'];
$idCliente = $_SESSION['idCliente'];

function contarProductosCarrito($idCliente, $con) {
    $getRows = $con->prepare("SELECT COUNT(*) as total_productos FROM pedidos, pedidos_productos WHERE pedidos.id_cliente = ? AND pedidos_productos.id = pedidos.id AND pedidos.status=0");
    $getRows->execute([$idCliente]);
    $result = $getRows->fetch(PDO::FETCH_OBJ);
    return $result->total_productos;
}

$totalProductos = 0;
if (!empty($idCliente)) {
    $totalProductos = contarProductosCarrito($idCliente, $con);
}
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/products.css" type="text/css">
    <link rel="icon" href="images/justbackground.png">
    <script src="js/jquery-3.3.1.min.js"></script>
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
            actualizarCarrito();

            window.agregarCarrito = function(producto_id, stock, costo) {
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
                        console.log(res); // Para depuración
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
                        actualizarCarrito(); // Actualiza el conteo del carrito
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText); // Para depuración
                        alert('Se ha producido un error: ' + error);
                    }
                });
            }
        });
    </script>
</head>
<body>
    <header id="navegation_bar">
        <a href="index.php">
            <img id="logo" src="images/diseñart.png" alt="logo">
        </a>
        <a class="link" id="home_link" href="index.php">
            <p>Home</p>
        </a> 
        <a class="link" href="productos.php">
            <p>Productos</p>
        </a>
        <a class="link" href="contacto_formulario.php">
            <p>Contacto</p>
        </a>
        <?php
        if (empty($correoCliente)) {
            echo "<a class='link' href='../Administración/index.php'>
                     <p>Iniciar Sesión</p>
                </a>";
        } else {
            echo "<a class='link' href='carrito01.php'>
                    <p>Carrito(<span id='cart_count'>$totalProductos</span>)</p>
                </a>";
        }
        if (!empty($correoCliente)) {
            echo "<a class='link' href='funciones/cerrar_sesion.php'>
                <p>Cerrar Sesión</p>
            </a>";
        }
        ?>
    </header>
    <div id="background_table">
        <?php foreach($productos as $producto) {
            $producto_id = $producto->id;
            $stock = $producto->stock;
            $costo = $producto->costo; ?>
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
                if (!empty($correoCliente)) {
                    echo "<input type='button' value='Añadir' class='addProductButton' onclick='agregarCarrito($producto_id, $stock, $costo);'>
                          <input type='number' id='cantidad_$producto_id' class='numberOfProducts' value='1' min='1' max='$stock'>
                          <div style='color:#233470;font-weight: bold;' id='mensaje_$producto_id'></div>";
                }
                ?>
            </div>
        <?php } ?>
    </div>
    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
