<?php
error_reporting(0);
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addClientFormCss.css" type="text/css">
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel = "icon" href="images/image.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script>

    function checkEmail(){
        var correo = document.addClientForm.correo.value;

        $.ajax({
            url: 'funciones/check_email.php',
            type: 'post',
            dataType: 'text',
            data: {correo: correo},
            success: function(response) {
                if (response == 'existing'){
                    $('#message').show(); 
                    $('#message').html('El correo ' + correo + ' ya existe.');
                    document.addClientForm.correo.value = '';
                    setTimeout(function(){
                        $('#message').html('');
                    }, 5000);
                }
            },
            error: function() {
                alert("Error al verificar el correo");
            }
        });

    }


        
    function validate(){
        var nombre = document.addClientForm.nombre.value;
        var apellidos = document.addClientForm.apellidos.value;
        var correo = document.addClientForm.correo.value;
        var pass = document.addClientForm.pass.value;
                
            if(nombre.length == 0 || apellidos.length == 0 || correo.length == 0 || pass.length == 0 ){
            $('#message').show();
            $('#message').html('Faltan campos por llenar');
            setTimeout(function(){
                $('#message').html('');
                $('#message').hide();
            }, 5000);
        }
        else{
            document.addClientForm.method = 'post';
            document.addClientForm.action = 'funciones/clientes_salva.php';
            document.addClientForm.submit();          
    }
}
    </script>

    <title>¡Regístrate!</title>
</head>

<body>
    <nav id="navegation_bar">
        <a href="index.php">
                <img id="client_image" src="images/diseñart.png" alt="Client">
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
    </nav>
    <div id="background">
        <div id="back_button">
            <a href = "../Administración/index.php">< Regresar</a>
        </div>
        <div id="principal">
            <img id="addClient" src="images/image.png">
            <h3 id="title">¡Regístrate!</h3>
        </div>
        <div id="addForm">
            <form enctype="multipart/form-data" name="addClientForm" id="addClientForm" method="post" action="funciones/clientes_salva.php">
                <label>
                    Nombre:
                    <input class="input" name="nombre" id="nombre" type="text" required>
                </label>
                <label>
                    Apellidos:
                    <input class="input" id="apellidos" name="apellidos" type="text" required>
                </label>
                <label>
                    Correo:
                    <input onfocus="" onblur="checkEmail();" class="input" name="correo" id="correo" type="email" placeholder="@" required> 
                </label>
                <label>
                    Contraseña:
                    <input class="input" name="pass" id="pass" type="password" required>
                </label>
                <br><br>
                <input id="addClientButton" type="button" onclick="validate(); return false;" value="Añadir"> 
            </form>
            <div id="message"></div>
        </div>
    </div>
    
</body>
</html>