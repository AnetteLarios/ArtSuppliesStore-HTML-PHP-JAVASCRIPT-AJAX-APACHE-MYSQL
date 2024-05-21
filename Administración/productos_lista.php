<?php
error_reporting(0);
session_start();
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}

require "funciones/conexionbd.php";
$con = conecta();

$getRows = $con->query("SELECT productos.id, productos.nombre, productos.codigo, productos.descripcion, productos.costo, productos.stock
                        FROM productos
                        WHERE  status = 1 AND eliminado = 0");
$num_products  = $getRows->rowCount();
$productos = $getRows->fetchAll(PDO::FETCH_OBJ);
?>

<html lang="es">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de productos</title>
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel = "stylesheet" href = "css/productsListCss.css" type="text/css">
        <link rel = "icon" href= "images/image1.png">
        <!--<script src="js/jquery-3.3.1.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script>
            function deleteProduct(input){
               
               var validation = confirm('¿Estás seguro de que quieres eliminar el registro?');
               if(validation == true){
                   var obtener = $(input).parent().parent().attr("id");
                   var rowId = String(obtener);
                   console.log(rowId);
                   $.ajax({
                       url: 'funciones/productos_elimina.php',
                       type: 'post',
                       dataType: 'text',
                       data: 'rowId='+rowId,
                       success: function(response) {
                           if (response == 1){
                           $(input).parent().parent().hide();
                           setTimeout(function() {
                                window.location.reload(); // Recarga la página después de 2 segundos
                            }, 2000);
                           } 
                           
                       },
                       error: function() {
                       alert("Error al enviar el Id de la fila: ");
                       }
                   });
                   
               }
           }
        </script>
    </head>
    <body>
        <header id="navegation_bar">
            <a href="productos_lista.php">
                    <img id="employee_image" src="images/image1.png" alt = "employee">
            </a>
            <p>Panel de administrador |</p>
            <?php
                include('menu.php');
            ?>
        </header>
        <div id="background_table">
            <div id="principal">
                <h3 id="title">Lista de productos (<?php echo $num_products; ?>)</h3>                
                <a href= "productos_alta.php">
                    <input id="newProduct" type="button" value="Crear nuevo">
                </a>
            </div>
            <div id="table_productos">
                <div id="header">
                    <div class="id">Id</div>
                    <div id="nombre">Nombre</div>
                    <div>Código</div>
                    <div>Descripcion</div>
                    <div>Costo</div>
                    <div>Stock</div>
                    <div>Ver detallle</div>
                    <div>Editar</div>
                    <div>Eliminar</div>
                </div>
                <?php foreach($productos as  $producto) { ?>
                <?php
                    $id_div =  $producto->id;
                ?>
                <div class="row" id="<?php echo "$id_div";?>">
                    <div class="id"><?php echo " $producto->id";?></div>
                    <div><?php echo " $producto->nombre";?></div>
                    <div ><?php echo " $producto->codigo";?></div>
                    <div><?php echo " $producto->descripcion";?></div>
                    <div><?php echo "$producto->costo";?></div>
                    <div><?php echo "$producto->stock";?></div>
                    <div>
                        <a href="productos_detalle.php?id=<?php echo $id_div;?>">
                            <input type="button" value="Ver detalle" class="viewDetails">
                        </a>
                    </div>
                    <div>
                        <a href="productos_editar.php?id=<?php echo $id_div;?>">
                            <input type="button" value="Editar" class="edit_Product">
                        </a>
                    </div>
                    <div>
                        <input id="deletePromotion" class="deleteRow" type="button" value="Eliminar" onclick="deleteProduct(this);" >
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </body>
</html>