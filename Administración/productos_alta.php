<?php

session_start();
error_reporting(0);
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addProductFormCss.css" type="text/css">
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel = "icon" href="images/productos.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script>

    function checkCode(){
        var codigo = document.addProductForm.codigo.value;

        $.ajax({
            url: 'funciones/check_product_code.php',
            type: 'post',
            dataType: 'text',
            data: {codigo: codigo},
            success: function(response) {
                if (response == 'existing'){
                    $('#message').show(); 
                    $('#message').html('El codigo ' + codigo + ' ya existe.');
                    document.addProductForm.codigo.value = '';
                    setTimeout(function(){
                        $('#message').html('');
                    }, 5000);
                }
            },
            error: function() {
                alert("Error al verificar el codigo");
            }
        });

    }


        
    function validate(){
        var nombre = document.addProductForm.nombre.value;
        var codigo = document.addProductForm.codigo.value;
        var descripcion = document.addProductForm.descripcion.value;
        var costo = document.addProductForm.costo.value;
        var stock = document.addProductForm.stock.value;
        var archivo_n = document.addProductForm.archivo_n.value;
                
            if(nombre.length == 0 || codigo.length == 0 || descripcion.length == 0 || costo.length == 0 || stock == 0 || document.getElementById('archivo_n').files.length == 0){
            $('#message').show();
            $('#message').html('Faltan campos por llenar');
            setTimeout(function(){
                $('#message').html('');
                $('#message').hide();
            }, 5000);
        }
        else{
            document.addProductForm.method = 'post';
            document.addProductForm.action = 'funciones/productos_salva.php';
            document.addProductForm.submit();          
    }
}
    </script>
    <title>Añadir Producto</title>
</head>

<body>
    <nav id="navegation_bar">
        <a href="productos_lista.php">
                <img id="employee_image" src="images/image1.png" alt="Employee">
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
          
        ?>
    </nav>
    <div id="background">
        <div id="back_button">
            <a href = "productos_lista.php">< Regresar</a>
        </div>
        <div id="principal">
            <img id="addEmployee" src="images/productos.png">
            <h3 id="title">Añadir Producto</h3>
        </div>
        <div id="addForm">
            <form enctype="multipart/form-data" name="addProductForm" id="addProductForm" method="post" action="funciones/productos_salva.php">
                <label>
                    Nombre:
                    <input class="input" name="nombre" id="nombre" type="text" required>
                </label>
                <label>
                    Código:
                    <input onfocus="" onblur="checkCode();"  class="input" id="codigo" name="codigo" type="text" required >
                </label>
                <label>
                    Descripción:
                    <input class="input" name="descripcion" id="descripcion" type="text" required> 
                </label>
                <label>
                    Costo:
                    <input class="input" name="costo" id="costo" type="number" required>
                </label>
                <label>
                    Stock:
                    <input class="input" name="stock" id="stock" type="number" required>
                </label>
                <br>
                <label>
                    <input type="file" id="archivo_n" name ="archivo_n" required> 
                </label>
                <br><br>
                <input id="addProductButton" type="button" onclick="validate(); return false;" value="Añadir"> 
            </form>
            <div id="message"></div>
        </div>
    </div>
    
</body>
</html>