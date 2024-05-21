<?php
error_reporting(0);
session_start();
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addPromotionFormCss.css" type="text/css">
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel = "icon" href="images/promocion.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script>

    function checkName(){
        var nombre = document.addPromotionForm.nombre.value;

        $.ajax({
            url: 'funciones/check_promotion_name.php',
            type: 'post',
            dataType: 'text',
            data: {nombre: nombre},
            success: function(response) {
                if (response == 'existing'){
                    $('#message').show(); 
                    $('#message').html('El nombre de promocion' + ' "' + nombre + '" ya existe.');
                    document.addPromotionForm.nombre.value = '';
                    setTimeout(function(){
                        $('#message').html('');
                    }, 5000);
                }
            },
            error: function() {
                alert("Error al verificar el nombre");
            }
        });

    }


        
    function validate(){
        var nombre = document.addPromotionForm.nombre.value;
        var archivo = document.addPromotionForm.archivo.value;
                
            if(nombre.length == 0 ||  document.getElementById('archivo').files.length == 0){
            $('#message').show();
            $('#message').html('Faltan campos por llenar');
            setTimeout(function(){
                $('#message').html('');
                $('#message').hide();
            }, 5000);
        }
        else{
            document.addPromotionForm.method = 'post';
            document.addPromotionForm.action = 'funciones/promociones_salva.php';
            document.addPromotionForm.submit();          
    }
}
    </script>

    <title>Añadir Promocion</title>
</head>

<body>
    <nav id="navegation_bar">
        <a href="promociones_lista.php">
                <img id="promotion_image" src="images/image1.png" alt="Promocion">
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

    </nav>
    <div id="background">
        <div id="back_button">
            <a href = "promociones_lista.php">< Regresar</a>
        </div>
        <div id="principal">
            <img id="addPromotion" src="images/promocion.png">
            <h3 id="title">Añadir Promoción</h3>
        </div>
        <div id="addForm">
            <form enctype="multipart/form-data" name="addPromotionForm" id="addPromotionForm" method="post" action="funciones/promociones_salva.php
            ">
                <label>
                    Nombre:
                    <input class="input" onblur="checkName();" name="nombre" id="nombre" type="text" required>
                </label>
                <br>
                <label>
                    <input type="file" id="archivo" name ="archivo" required> 
                </label>
                <br><br>
                <input id="addPromotionButton" type="button" onclick="validate(); return false;" value="Añadir"> 
            </form>
            <div id="message"></div>
        </div>
    </div>
    
</body>
</html>