<?php
require "funciones/conexionbd.php";
$con = conecta();
session_start();
$correoCliente = $_SESSION['correoCliente'];
$idCliente = $_SESSION['idCliente'];
function contarProductosCarrito($idCliente, $con) {
    $getRows = $con->prepare("SELECT COUNT(*) as total_productos FROM pedidos, pedidos_productos WHERE pedidos.id_cliente = ? AND pedidos_productos.id = pedidos.id AND pedidos.status=0");
    $getRows->execute([$idCliente]);
    $result = $getRows->fetch(PDO::FETCH_OBJ);
    return $result->total_productos;
}

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/contactFormCss.css" type="text/css">
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
        function formSubmit(event) {
            event.preventDefault();
            var form = $('#contact_form');
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    $('#message').show();
                    $('#message').html(response);
                    setTimeout(function() {
                        $('#message').html('');
                        $('#message').hide();
                    }, 5000);
                },
                error: function() {
                    $('#message').show();
                    $('#message').html('Error al enviar el comentario.');
                    setTimeout(function() {
                        $('#message').html('');
                        $('#message').hide();
                    }, 5000);
                }
            });
        }

        $(document).ready(function() {
            $('#contact_form').on('submit', formSubmit);
        });
    </script>
</head>
<body>
    <header id="navegation_bar">
        <a href="index.php">
            <img id="logo" src="images/diseñart.png" alt="logo">
        </a>
        <?php
        ?>
        <a class="link" id="home_link" href="index.php">
            <p> Home</p>
        </a>
        <a class="link" href="productos.php">
            <p> Productos</p>
        </a>
        <a class="link" href="contacto_formulario.php">
            <p> Contacto</p>
        </a>
        <?php
        if (empty($correoCliente)) {
            echo "<a class='link' href='../Administración/index.php'>
                    <p> Iniciar Sesión </p>
                </a>";
        } else {
            echo "<a class='link' href='carrito01.php'>
                    <p> Carrito(<span id='cart_count'>0</span>)</p>
                </a>";
        }
        if (!empty($correoCliente)) {
            echo "<a class='link' href='funciones/cerrar_sesion.php'>
                <p> Cerrar Sesión</p>
            </a>";
        }
        ?>
    </header>
    <p id="title">Formulario de Contacto</p>
    <form name="contact_form" id="contact_form" method="post" action="funciones/contacto_envia.php">
        <label>
            Nombre:
            <br>
            <input type="text" name="nombre" required>
        </label>
        <br>
        <label>
            Apellidos:
            <br>
            <input type="text" name="apellidos" required>
        </label>
        <br>
        <label>
            Correo:
            <br>
            <input type="email" name="correo" placeholder="@" required> 
        </label>
        <br>
        <label>
            Comentario:
            <br>
            <input type="text" name="comentario" id="comment" required>
        </label>
        <br><br>
        <input id="submit_button" type="submit" value="Enviar"></input>
        <div id="message" style="display:none;"></div>
    </form>
    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
