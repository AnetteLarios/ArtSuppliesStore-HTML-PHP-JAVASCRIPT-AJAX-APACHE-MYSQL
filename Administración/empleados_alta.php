<?php
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
    <link rel="stylesheet" href="css/addEmployeeFormCss.css" type="text/css">
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel = "icon" href="images/image.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script>

    function checkEmail(){
        var correo = document.addEmployeeForm.correo.value;

        $.ajax({
            url: 'funciones/check_email.php',
            type: 'post',
            dataType: 'text',
            data: {correo: correo},
            success: function(response) {
                if (response == 'existing'){
                    $('#message').show(); 
                    $('#message').html('El correo ' + correo + ' ya existe.');
                    document.addEmployeeForm.correo.value = '';
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
        var nombre = document.addEmployeeForm.nombre.value;
        var apellidos = document.addEmployeeForm.apellidos.value;
        var correo = document.addEmployeeForm.correo.value;
        var pass = document.addEmployeeForm.pass.value;
        var id_rol = document.addEmployeeForm.id_rol.value;
        var archivo_n = document.addEmployeeForm.archivo_n.value;
                
            if(nombre.length == 0 || apellidos.length == 0 || correo.length == 0 || pass.length == 0 || id_rol == 0 || document.getElementById('archivo_n').files.length == 0){
            $('#message').show();
            $('#message').html('Faltan campos por llenar');
            setTimeout(function(){
                $('#message').html('');
                $('#message').hide();
            }, 5000);
        }
        else{
            document.addEmployeeForm.method = 'post';
            document.addEmployeeForm.action = 'funciones/empleados_salva.php';
            document.addEmployeeForm.submit();          
    }
}
    </script>

    <title>Añadir Empleado</title>
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
            <img id="addEmployee" src="images/image.png">
            <h3 id="title">Añadir Empleado</h3>
        </div>
        <div id="addForm">
            <form enctype="multipart/form-data" name="addEmployeeForm" id="addEmployeeForm" method="post" action="funciones/empleados_salva.php">
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
                <label for="id_rol">Rol:
                    <select class="input" name="id_rol" id="id_rol">
                        <option value="0" selected>Selecciona una opción...</option>
                        <option value="1">Gerente</option>
                        <option value="2">Ejecutivo</option>        
                    </select>
                </label>
                <br>
                <label>
                    <input type="file" id="archivo_n" name ="archivo_n" required> 
                </label>
                <br><br>
                <input id="addEmployeeButton" type="button" onclick="validate(); return false;" value="Añadir"> 
            </form>
            <div id="message"></div>
        </div>
    </div>
    
</body>
</html>