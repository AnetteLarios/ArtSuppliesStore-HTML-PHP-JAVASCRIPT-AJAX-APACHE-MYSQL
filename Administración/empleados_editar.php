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
$sentencia = "SELECT id, nombre, apellidos, correo, pass, id_rol, archivo_n, archivo_f FROM empleados  WHERE empleados.id = $id;";

$resultado = $con->query($sentencia);
$employeeData = $resultado->fetchAll(PDO::FETCH_OBJ);

?>

<html>
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Empleado</title>
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
        <link rel = "stylesheet" href = "css/editEmployeeFormCss.css" type="text/css">
        <link rel = "icon" href= "images/image1.png">
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script>

            function checkEmail(){
                var correo = document.editEmployeeForm.correo.value;

                $.ajax({
                    url: 'funciones/check_edit_email.php',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        correo: correo,
                        id: <?php echo $id; ?>},
                    success: function(response) {
                        if (response == 'existing'){
                            $('#message').show(); 
                            $('#message').html('El correo ' + correo + ' ya existe.');
                            document.editEmployeeForm.correo.value = '';
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
                var nombre = document.editEmployeeForm.nombre.value;
                var apellidos = document.editEmployeeForm.apellidos.value;
                var correo = document.editEmployeeForm.correo.value;
                var pass = document.editEmployeeForm.pass.value;
                var id_rol = document.editEmployeeForm.id_rol.value;
                
                if(nombre.length == 0 || apellidos.length == 0 || correo.length == 0 || id_rol == 0){
                $('#message').show();
                $('#message').html('Faltan campos por llenar');
                setTimeout(function(){
                    $('#message').html('');
                    $('#message').hide();
                }, 5000);
                }
                else{
                    document.editEmployeeForm.method = 'post';
                    document.editEmployeeForm.action = 'funciones/empleados_actualiza.php?id=<?php echo $id;?>';
                    document.editEmployeeForm.submit();          
                }
            }
        </script>
    </head>
    <body>
        <nav id="navegation_bar">
            <a href="empleados_lista.php">
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
                <a href = "empleados_lista.php">< Regresar</a>
            </div>
            <div id="principal">
                <img id="editEmployee" src="images/image.png">
                <h3 id="title">Editar Empleado</h3>
            </div>
            <div id="editForm">
            <?php foreach($employeeData as $data){?>
                <form enctype="multipart/form-data" name="editEmployeeForm" id="editEmployeeForm" method="post" action="funciones/empleados_actualiza.php">
                    <label>
                        Nombre:
                        <input class="input" name="nombre" id="nombre" type="text" required value="<?php echo $data->nombre;?>">
                    </label>
                    <label>
                        Apellidos:
                        <input class="input" id="apellidos" name="apellidos" type="text" required value="<?php echo $data->apellidos;?>">
                    </label>
                    <label>
                        Correo:
                        <input onfocus="" onblur="checkEmail();" class="input" name="correo" id="correo" type="email" required value="<?php echo $data->correo;?>"> 
                    </label>
                    <label>
                        Contraseña:
                        <input class="input" name="pass" id="pass" type="password" required value="<?php echo $data->pass;?>">
                    </label>
                    <label for="id_rol">Rol:
                        <select class="input" name="id_rol" id="id_rol">
                            <option value="0">Selecciona una opción...</option>
                            <option value="1" <?php if ($data->id_rol == 1) echo "selected"; ?>>Gerente</option>
                         <  <option value="2" <?php if ($data->id_rol == 2) echo "selected"; ?>>Ejecutivo</option>       
                        </select>
                    </label>
                    <?php if(empty($data->archivo_n)){
                        echo "<p>Ningún archivo se ha cargado</p>";
                        echo"<input type='file' id='archivo_n' name ='archivo_n'>";
                    }else{
                        echo "<p>Imagen cargada:</p> <img id='user_prof_pic' src='user_files/{$data->archivo_f}'><br>";
                        echo "<label><p>Cargar nueva imagen:</p></label>";
                        echo"<input type='file' id='archivo_n' name ='archivo_n'>";
                    }
                    ?>
                    <br><br>
                    <input id="editEmployeeButton" type="button" onclick="validate(); return false;" value="Editar"> 
                </form>
            <?php }?>
            <div id="message"></div>
        </div>
    </body>
</html>