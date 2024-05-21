<?php
error_reporting(0);
session_start();
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}

require "funciones/conexionbd.php";
$con = conecta();

$getRows = $con->query("SELECT empleados.id, empleados.nombre, empleados.apellidos, empleados.correo, empleados.status, rol.rol
                        FROM empleados, rol
                        WHERE empleados.id_rol = rol.id AND status = 1 AND eliminado = 0");
$num_employees  = $getRows->rowCount();
$empleados = $getRows->fetchAll(PDO::FETCH_OBJ);
?>

<html lang="es">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de empleados</title>
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel = "stylesheet" href = "css/styles.css" type="text/css">
        <link rel = "icon" href= "images/image1.png">
        <!--<script src="js/jquery-3.3.1.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script>
            function deleteEmployee(input){
               
               var validation = confirm('¿Estás seguro de que quieres eliminar el registro?');
               if(validation == true){
                   var obtener = $(input).parent().parent().attr("id");
                   var rowId = String(obtener);
                   console.log(rowId);
                   $.ajax({
                       url: 'funciones/empleados_elimina.php',
                       type: 'post',
                       dataType: 'text',
                       data: 'rowId='+rowId,
                       success: function(response) {
                           if (response == 1){
                           $(input).
                           parent().parent().hide();
                           } 
                           setTimeout(function() {
                                window.location.reload(); // Recarga la página después de 2 segundos
                            }, 2000);
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
            <a href="empleados_lista.php">
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
                <h3 id="title">Lista de empleados (<?php echo $num_employees; ?>)</h3>                
                <a href= "empleados_alta.php">
                    <input id="newEmployee" type="button" value="Crear nuevo">
                </a>
            </div>
            <div id="table_empleados">
                <div id="header">
                    <div class="id">Id</div>
                    <div id="nombre">Nombre Completo</div>
                    <div class="email">Correo</div>
                    <div id="rol">Rol</div>
                    <div>Ver detalle</div>
                    <div>Editar</div>
                    <div>Eliminar</div>
                </div>
                <?php foreach($empleados as $empleado) { ?>
                <?php
                    $id_div = $empleado->id;
                ?>
                <div class="row" id="<?php echo "$id_div";?>">
                    <div class="id"><?php echo "$empleado->id";?></div>
                    <div><?php echo "$empleado->nombre"; echo " "; echo"$empleado->apellidos";?></div>
                    <div class="email"><?php echo "$empleado->correo";?></div>
                    <div><?php echo "$empleado->rol";?></div>
                    <div>
                        <a href="empleados_detalle.php?id=<?php echo $id_div;?>">
                            <input type="button" value="Ver detalle" class="viewDetails">
                        </a>
                    </div>
                    <div>
                        <a href="empleados_editar.php?id=<?php echo $id_div;?>">
                            <input type="button" value="Editar" class="edit_Employee">
                        </a>
                    </div>
                    <div>
                        <input id="deleteEmployee" class="deleteRow" type="button" value="Eliminar" onclick="deleteEmployee(this);" >
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </body>
</html>