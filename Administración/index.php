<?php

session_start();

$nombre = $_SESSION['nombreUser'];

if(!empty($nombre)){
    header("Location: bienvenido.php");
}

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/loginEmployeeFormCss.css" type="text/css">
    <link rel="icon" href="images/image1.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script>
        function verifyUser() {
            var correo = $('#correo').val();
            var pass = $('#pass').val();

            $.ajax({
                url: 'funciones/verify_user.php',
                type: 'POST',
                data: 'correo=' + correo + '&pass=' + pass,
                dataType: 'json', // Especificamos que esperamos un objeto JSON como respuesta
                success: function(response) {
                    if (response.success) {
                        // Credenciales correctas, redireccionar
                        window.location.href = 'bienvenido.php';
                    } else {
                        // Credenciales incorrectas, mostrar mensaje de error
                        $('#message').show();
                        $('#message').html(response.message);
                        $('#correo').val('');
                        $('#pass').val('');
                        setTimeout(function() {
                            $('#message').html('');
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

        function validate() {
            var correo = document.loginEmployeeForm.correo.value;
            var pass = document.loginEmployeeForm.pass.value;

            if (correo.length == 0 || pass.length == 0) {
                $('#message').show();
                $('#message').html('Faltan campos por llenar');
                setTimeout(function() {
                    $('#message').html('');
                    $('#message').hide();
                }, 5000);
            } else {
                verifyUser();
            }
        }
    </script>
</head>

<body>
    <nav id="navegation_bar">
        <a href="empleados_lista.php">
            <img id="employee_image" src="images/image1.png" alt="Employee">
        </a>
        <p>Panel de administrador</p>
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
                <input id="loginEmployeeButton" type="button" onclick="validate(); return false;" value="Ingresar">
            </form>
            <div id="message"></div>
        </div>
    </div>
</body>

</html>
