<?php
error_reporting(0);

session_start();
$correoCliente = $_SESSION['correoCliente'];
$idCliente = $_SESSION['idCliente'];

if(empty($idCliente)){
    header("Location: ../Administración/index.php");
}

require "funciones/conexionbd.php";
$con = conecta();

function obtenerProductosCarrito($idCliente, $con) {
    $getRows = $con->prepare("SELECT pedidos_productos.id as id_pedido, pedidos_productos.id_producto as id_producto, productos.nombre as nombre, productos.stock as stock, pedidos_productos.precio as precio, pedidos_productos.cantidad as cantidad
        FROM pedidos, pedidos_productos, productos 
        WHERE pedidos.id_cliente = ? AND pedidos_productos.id = pedidos.id AND productos.id = pedidos_productos.id_producto AND pedidos.status=0");
    $getRows->execute([$idCliente]);
    return $getRows->fetchAll(PDO::FETCH_OBJ);
}

$products = obtenerProductosCarrito($idCliente, $con);
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/carrito01.css" type="text/css">
    <link rel="icon" href="images/justbackground.png">
    <title>Diseñart</title>
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
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
<div id="background_table">
    <p id="title"> Pedido 1/2</p>
    <div id="header_table">
        <div>Producto</div>
        <div>Cantidad</div>
        <div>Costo unitario</div>
        <div>Subtotal</div>
        <div>Acción</div>
    </div>
    <?php
    $total = 0;
    foreach ($products as $product) {
        $producto_id = $product->id_producto;
        $pedido_id = $product->id_pedido;
        $nombre = $product->nombre;
        $cantidad = $product->cantidad;
        $costo = $product->precio;
        $subtotal = $costo * $cantidad;
        $total += $subtotal;
        ?>
        <div class="fila" id='fila<?php echo $producto_id; ?>'>
            <div><?php echo $nombre; ?></div>
            <div><input id='cantidad<?php echo $producto_id; ?>' class="cantidad" type="number" value="<?php echo $cantidad; ?>" onchange="cambiaCantidad(<?php echo $producto_id; ?>, <?php echo $pedido_id; ?>, <?php echo $costo; ?>, <?php echo $cantidad; ?>)"></input></div>
            <div>$<?php echo $costo; ?>.00</div>
            <div id='subtotal<?php echo $producto_id; ?>' class="columnaSubtotal"><?php echo '$' . $subtotal; ?></div>
            <div><input value="Eliminar" type="button" class="delete_button" onclick="eliminarFila(<?php echo $producto_id; ?>, <?php echo $pedido_id; ?>, '<?php echo $nombre; ?>');"></input></div>
        </div>
        <?php
    }
    ?>
    <div class="fila final_row">
        <div></div>
        <div></div>
        <div></div>
        <div id="total">Total: <span id="total"><?php echo '$' . $total; ?></span></div>
        <div></div>
    </div>
</div>
<?php if (!empty($products)) { ?>
    <a href="carrito02.php">
        <input id='continue_button' type='button' value='Continuar' >
    </a>
<?php } ?>
<footer>
    <?php include('footer.php'); ?>
</footer>
<script>
    function eliminarFila(producto_id, pedido_id, nombre) {
        if (confirm('¿Estás seguro de que quieres eliminar el producto ' + nombre + '?')) {
            if (producto_id) {
                $.ajax({
                    url: 'funciones/carrito_elimina.php',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        producto_id: producto_id,
                        pedido_id: pedido_id
                    },
                    success: function (res) {
                        if (res == 1) {
                            // Eliminar la fila de la tabla
                            $('#fila' + producto_id).remove();
                            // Recalcular el total
                            var total = 0;
                            $('.columnaSubtotal').each(function () {
                                total += parseFloat($(this).text().slice(1));
                            });
                            $('#total').text('$' + total);
                        } else {
                            alert('Se ha producido un error');
                        }
                    },
                    error: function () {
                        alert('Error archivo no encontrado...');
                    }
                });
            } else {
                alert('Se ha producido un error');
            }
        }
    }

    function cambiaCantidad(producto_id, pedido_id, costo, cantidadAnt) {
        var cantidad = $('#cantidad' + producto_id).val();
        cantidad = parseInt(cantidad);
        cantidadAnt = parseInt(cantidadAnt);
        costo = parseInt(costo);

        if (cantidad) {
            $.ajax({
                url: 'funciones/carrito_cambiaCantidad.php',
                type: 'post',
                dataType: 'text',
                data: 'producto_id=' + producto_id + '&pedido_id=' + pedido_id + '&cantidad=' + cantidad,
                success: function (res) {
                    if (res == 1) {
                        // Calcula subtotal
                        var subtotal = cantidad * costo;
                        $('#subtotal' + producto_id).html('$' + subtotal);
                        // Recalcular el total
                        var total = 0;
                        $('.columnaSubtotal').each(function () {
                            total += parseInt($(this).text().slice(1));
                        });
                        $('#total').html('$' + total );
                        alert('Cantidad del producto modificada');
                    } else {
                        alert('Se ha producido un error...');
                    }
                },
                error: function () {
                    alert('Error archivo no encontrado...');
                }
            });
        } else {
            alert('Se ha producido un error...');
        }
    }
</script>
</body>
</html>
