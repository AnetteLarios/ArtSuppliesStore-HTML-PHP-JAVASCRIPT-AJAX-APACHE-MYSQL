<?php
session_start();
$nombre = $_SESSION['nombreUser'];
if(empty($nombre)){
    header("Location: index.php");
}
require "funciones/conexionbd.php";
$con = conecta();

$id = $_REQUEST['id'];

$sentencia = "SELECT empleados.nombre, empleados.apellidos, empleados.correo, rol.rol, empleados.status, empleados.archivo_f
              FROM empleados, rol
              WHERE empleados.id_rol = rol.id AND empleados.id = $id";


$resultado = $con->query($sentencia);
$data = $resultado->fetchAll(PDO::FETCH_OBJ);
?>

<html lang="es">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1.0">
    <title>Letalle empleados</title>
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel = "stylesheet" href = "css/detailsEmployee.css" type="text/css">
    <link rel = "icon" href= "images/group.png">
    <!--<script src="js/jquery-3.3.1.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    </head>

    <body>
        <header id="navegation_bar">
            <a href="empleados_lista.php">
                    <img id="employee_image" src="images/image1.png" alt = "employee">
            </a>
            <p>Panel de administrador |</p>
            <?php
                include('menu.php');
            ?>
        </header>
        <div id="background_table">
            <div id="back_button">
            <a href = "empleados_lista.php">< Regresar</a>
            </div>
            <div id="principal">
                <img id="employee" src="images/empleados.png">
                <h3 id="title">Detalle Empleado</h3>                
            </div>
            <div id="full_details_table">
                <div id="table_header">
                    <div class="header_field">Nombre</div>
                    <div class="header_field">Correo</div>
                    <div class="header_field">Rol</div>
                    <div class="header_field">Estado</div>
                    <div class="header_field">Imagen</div>
                </div>
                <?php foreach ($data as $dataEmployee){
                    $estado = ($dataEmployee->status == 1) ? 'Activo' : 'Inactivo'; ?>
                <div id="dataRow" >
                    <div class="dataCell"><?php echo $dataEmployee->nombre . ' ' . $dataEmployee->apellidos;?></div>
                    <div class="dataCell"><?php echo $dataEmployee->correo?></div>
                    <div class="dataCell"><?php echo $dataEmployee->rol?></div>
                    <div class="dataCell"><?php echo $estado?></div>
                    <div class="dataCell"><?php echo "<img id='user_image' alt='user_image' src='user_files/{$dataEmployee->archivo_f}'>"?></div>
                </div <?php }?>>
            </div>
        </div>
    </body>
</html>