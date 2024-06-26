<?php
error_reporting(0);
session_start();

$nombreCliente = $_SESSION['nombreCliente'];
$nombreAdmin = $_SESSION['nombreUser'];
if(!empty($nombreAdmin)){
    header("Location: bienvenido.php");
}

if(!empty($nombre)){
    header("Location: ../Usuarios/index.php");
}

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/loginEmployeeFormCss.css" type="text/css">
    <link rel="icon" href="../Usuarios/images/justbackground.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script>
        function verifyUser() {
            var correo = $('#correo').val();
            var pass = $('#pass').val();

            $.ajax({
                url: 'funciones/verify_user.php',
                type: 'POST',
                data: { correo: correo, pass: pass },
                dataType: 'json',
                success: function(response) {
                    if (response.type === "admin") {
                        // Redirigir a la página de empleado
                        window.location.href = 'bienvenido.php';
                    } else if (response.type === "cliente") {
                        // Redirigir a la página de cliente
                        window.location.href = '../Usuarios/index.php';
                    } else {
                        // Mostrar mensaje de error
                        $('#message').show();
                        $('#message').html(response.message);
                        setTimeout(function() {
                            $('#message').html('');
                            $('#message').hide();
                        }, 5000);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error en la solicitud AJAX:", status, error);
                    $('#message').show();
                    $('#message').html('Ha ocurrido un error al procesar la solicitud');
                }
            });
        }
    </script>
</head>

<body>
    <nav id="navegation_bar">
        <a href="../Usuarios/index.php">
            <img id="employee_image" src="../Usuarios/images/diseñart.png" alt="Employee">
            <?php ;
?>
    <a class="link" id="home_link" href = "../Usuarios/index.php">
        <p> Home</p>
    </a> 
    <a class="link" href = "../Usuarios/productos.php">
        <p> Productos</p>
    </a>
    <a class="link" href = "../Usuarios/contacto_formulario.php">
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
        </a>
    </nav>
    <div id="background">
        <div id="principal">
            <!--<img>-->
            <h3 id="title">Iniciar Sesión</h3>
        </div>
        <div id="loginForm">
            <form name="loginEmployeeForm" id="loginEmployeeForm" method="post">
                <label>
                    Correo:
                    <input class="input" name="correo" id="correo" type="text" required>
                </label>
                <br>
                <label>
                    Contraseña:
                    <input class="input" id="pass" name="pass" type="password" required>
                </label>
                <br>
                <input id="loginEmployeeButton" type="button" onclick="verifyUser();" value="Ingresar">
            </form>
            <a  id="register" href="../Usuarios/clientes_alta.php">
                <p>¿No tienes una cuenta? ¡Regístrate!</p>
            </a>
            <div id="message"></div>
        </div>
    </div>
    <footer>
    <?php include ('footer.php');?>
    </footer>
</body>
</html>