<?php 
session_start();
error_reporting(0);
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}

require "funciones/conexionbd.php";

$con = conecta();
$id = $_REQUEST['id'];
$sentencia = "SELECT id, nombre, archivo FROM promociones  WHERE promociones.id = $id;";

$resultado = $con->query($sentencia);
$promotionData = $resultado->fetchAll(PDO::FETCH_OBJ);

?>

<html>
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Promoción</title>
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel = "stylesheet" href = "css/editPromotionFormCss.css" type="text/css">
        <link rel = "icon" href= "images/image1.png">
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script>

            function checkName(){
                var nombre = document.editPromotionForm.nombre.value;

                $.ajax({
                    url: 'funciones/check_edit_name_promotion.php',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        nombre: nombre,
                        id: <?php echo $id; ?>},
                    success: function(response) {
                        if (response == 'existing'){
                            $('#message').show(); 
                            $('#message').html('El nombre ' + nombre + ' ya existe.');
                            document.editPromotionForm.nombre.value = '';
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
                var nombre = document.editPromotionForm.nombre.value;
                
                if(nombre.length == 0){
                $('#message').show();
                $('#message').html('Faltan campos por llenar');
                setTimeout(function(){
                    $('#message').html('');
                    $('#message').hide();
                }, 5000);
                }
                else{
                    document.editPromotionForm.method = 'post';
                    document.editPromotionForm.action = 'funciones/promociones_actualiza.php?id=<?php echo $id;?>';
                    document.editPromotionForm.submit();          
                }
            }
        </script>
    </head>
    <body>
        <nav id="navegation_bar">
            <a href="promociones_lista.php">
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

        </nav>
        <div id="background">
             <div id="back_button">
                <a href = "promociones_lista.php">< Regresar</a>
            </div>
            <div id="principal">
                <img id="editPromotion" src="images/promocion.png">
                <h3 id="title">Editar Promoción</h3>
            </div>
            <div id="editForm">
            <?php foreach($promotionData as $data){?>
                <form enctype="multipart/form-data" name="editPromotionForm" id="editPromotionForm" method="post" action="funciones/promociones_actualiza.php">
                    <label>
                        Nombre:
                        <input class="input" name="nombre" id="nombre" onblur="checkName();" type="text" required value="<?php echo $data->nombre;?>">
                    </label>

                    <?php if(empty($data->archivo)){
                        echo "<p>Ningún archivo se ha cargado</p>";
                        echo"<input type='file' id='archivo' name ='archivo'>";
                    }else{
                        echo "<p>Imagen cargada:</p> <img id='promotion_picture' src='promotion_files/{$data->archivo}'><br>";
                        echo "<label><p>Cargar nueva imagen:</p></label>";
                        echo"<input type='file' id='archivo' name ='archivo'>";
                    }
                    ?>
                    <br><br>
                    <input id="editPromotionButton" type="button" onclick="validate(); return false;" value="Editar"> 
                </form>
            <?php }?>
            <div id="message"></div>
        </div>
    </body>
</html>