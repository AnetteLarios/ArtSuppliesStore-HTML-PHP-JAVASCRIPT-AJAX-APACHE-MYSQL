<?php

require "funciones/conexionbd.php";
$con = conecta();

$getRows = $con->query("SELECT promociones.id, promociones.nombre
                        FROM promociones
                        WHERE status = 1 AND eliminado = 0");
$num_promotions  = $getRows->rowCount();
$promociones = $getRows->fetchAll(PDO::FETCH_OBJ);


error_reporting(0);
session_start();
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}

?>

<html lang="es">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de promociones</title>
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel = "stylesheet" href = "css/promotionsListCss.css" type="text/css">
        <link rel = "icon" href= "images/image1.png">
        <!--<script src="js/jquery-3.3.1.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script>
            function deletePromotion(input){
               
               var validation = confirm('¿Estás seguro de que quieres eliminar el registro?');
               if(validation == true){
                   var obtener = $(input).parent().parent().attr("id");
                   var rowId = String(obtener);
                   console.log(rowId);
                   $.ajax({
                       url: 'funciones/promociones_elimina.php',
                       type: 'post',
                       dataType: 'text',
                       data: 'rowId='+rowId,
                       success: function(response) {
                           if (response == 1){
                           $(input).parent().parent().hide();
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
            <a href="promociones_lista.php">
                    <img id="employee_image" src="images/image1.png" alt = "employee">
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

        </header>
        <div id="background_table">
            <div id="principal">
                <h3 id="title">Lista de promociones (<?php echo $num_promotions; ?>)</h3>                
                <a href= "promociones_alta.php">
                    <input id="newPromotion" type="button" value="Crear nuevo">
                </a>
            </div>
            <div id="table_promociones">
                <div id="header">
                    <div class="id">Id</div>
                    <div id="nombre">Nombre</div>
                    <div>Ver detalle</div>
                    <div>Editar</div>
                    <div>Eliminar</div>
                </div>
                <?php foreach($promociones as $promocion) { ?>
                <?php
                    $id_div = $promocion->id;
                ?>
                <div class="row" id="<?php echo "$id_div";?>">
                    <div class="id"><?php echo "$promocion->id";?></div>
                    <div><?php echo "$promocion->nombre";?></div>
                    <div>
                        <a href="promociones_detalle.php?id=<?php echo $id_div;?>">
                            <input type="button" value="Ver detalle" class="viewDetails">
                        </a>
                    </div>
                    <div>
                        <a href="promociones_editar.php?id=<?php echo $id_div;?>">
                            <input type="button" value="Editar" class="edit_Employee">
                        </a>
                    </div>
                    <div>
                        <input id="deletePromotion" class="deleteRow" type="button" value="Eliminar" onclick="deletePromotion(this);" >
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </body>
</html>