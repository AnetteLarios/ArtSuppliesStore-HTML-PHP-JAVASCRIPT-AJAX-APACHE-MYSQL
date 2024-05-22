<?php 
error_reporting(0);
session_start();
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}

require "funciones/conexionbd.php";

$con = conecta();
$id = $_REQUEST['id'];
$sentencia = "SELECT id, nombre, codigo, descripcion, costo, stock, archivo_n, archivo_f FROM productos  WHERE productos.id = $id;";

$resultado = $con->query($sentencia);
$productData = $resultado->fetchAll(PDO::FETCH_OBJ);

?>

<html>
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Producto</title>
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel = "stylesheet" href = "css/editProductFormCss.css" type="text/css">
        <link rel = "icon" href= "images/image1.png">
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script>

            function checkCode(){
                var codigo = document.editProductForm.codigo.value;

                $.ajax({
                    url: 'funciones/check_edit_code_product.php',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        codigo: codigo,
                        id: <?php echo $id; ?>},
                    success: function(response) {
                        if (response == 'existing'){
                            $('#message').show(); 
                            $('#message').html('El codigo ' + codigo + ' ya existe.');
                            document.editProductForm.codigo.value = '';
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
                var nombre = document.editProductForm.nombre.value;
                var codigo = document.editProductForm.codigo.value;
                var descripcion = document.editProductForm.descripcion.value;
                var costo = document.editProductForm.costo.value;
                var stock = document.editProductForm.stock.value;
                
                if(nombre.length == 0 || codigo.length == 0 || descripcion.length == 0 || stock.length  == 0 || costo.length == 0){
                $('#message').show();
                $('#message').html('Faltan campos por llenar');
                setTimeout(function(){
                    $('#message').html('');
                    $('#message').hide();
                }, 5000);
                }
                else{
                    document.editProductForm.method = 'post';
                    document.editProductForm.action = 'funciones/productos_actualiza.php?id=<?php echo $id;?>';
                    document.editProductForm.submit();          
                }
            }
        </script>
    </head>
    <body>
        <nav id="navegation_bar">
            <a href="productos_lista.php">
                <img id="employee_image" src="images/image1.png" alt="Employee">
            </a>
            <p>Panel de administrador |</p>
            <?php ?>
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
                <a href = "productos_lista.php">< Regresar</a>
            </div>
            <div id="principal">
                <img id="editProduct" src="images/productos.png">
                <h3 id="title">Editar Producto</h3>
            </div>
            <div id="editForm">
            <?php foreach($productData as $data){?>
                <form enctype="multipart/form-data" name="editProductForm" id="editProductForm" method="post" action="funciones/productos_actualiza.php">
                    <label>
                        Nombre:
                        <input class="input" name="nombre" id="nombre" type="text" required value="<?php echo $data->nombre;?>">
                    </label>
                    <label>
                        Código:
                        <input onfocus="" onblur="checkCode();"class="input" id="codigo" name="codigo" type="text" required value="<?php echo $data->codigo;?>">
                    </label>
                    <label>
                        Descripción:
                        <input  class="input" name="descripcion" id="descripcion" type="text" required value="<?php echo $data->descripcion;?>"> 
                    </label>
                    <label>
                        Costo:
                        <input class="input" name="costo" id="costo" type="number" required value="<?php echo $data->costo;?>">
                    </label>
                    <label>
                        Stock:
                        <input class="input" name="stock" id="stock" type="number" required value="<?php echo $data->stock;?>">
                    </label>
                    
                    
                    <?php if(empty($data->archivo_n)){
                        echo "<p>Ningún archivo se ha cargado</p>";
                        echo"<input type='file' id='archivo_n' name ='archivo_n'>";
                    }else{
                        echo "<p>Imagen cargada:</p> <img id='product_picture' src='product_files/{$data->archivo_f}'><br>";
                        echo "<label><p>Cargar nueva imagen:</p></label>";
                        echo"<input type='file' id='archivo_n' name ='archivo_n'>";
                    }
                    ?>
                    <br><br>
                    <input id="editProductButton" type="button" onclick="validate(); return false;" value="Editar"> 
                </form>
            <?php }?>
            <div id="message"></div>
        </div>
    </body>
</html>