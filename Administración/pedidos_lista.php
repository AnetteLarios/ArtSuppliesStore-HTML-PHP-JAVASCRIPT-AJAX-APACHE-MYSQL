<?php
error_reporting(0);
session_start();
$nombre = $_SESSION['soloNombreUser'];
if(empty($nombre)){
    header("Location: index.php");
    exit; // Agrega una salida para evitar que el código siga ejecutándose si no hay sesión activa
}

require "funciones/conexionbd.php";
$con = conecta();

$getRows = $con->query("SELECT pedidos.id, pedidos.fecha, pedidos.id_cliente, pedidos.status, clientes.correo
                        FROM pedidos
                        INNER JOIN clientes ON pedidos.id_cliente = clientes.id
                        WHERE pedidos.status = 1"); // Corrige la consulta SQL, elimina la coma antes de FROM y asegúrate de que esté bien formateada
$num_pedidos  = $getRows->rowCount();
$pedidos = $getRows->fetchAll(PDO::FETCH_OBJ);
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de pedidos</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="css/OrdersListCss.css" type="text/css">
    <link rel="icon" href="images/image1.png">
    <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
    <script>
        $(document).ready(function() {
            $('.deleteButton').on('click', function() {
                var rowId = $(this).closest('.row').attr('id');
                if(confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                    $.ajax({
                        url: 'funciones/pedidos_elimina.php',
                        type: 'post',
                        dataType: 'text',
                        data: 'rowId=' + rowId,
                        success: function(response) {
                            if(response == 1) {
                                $('#' + rowId).hide(300);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        },
                        error: function() {
                            alert("Error al enviar el Id de la fila");
                        }
                    });
                }
            });
        });
    </script>
</head>
<body>
<header id="navegation_bar">
    <a href="bienvenido.php">
        <img id="employee_image" src="images/image1.png" alt="employee">
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
        <h3 id="title">Lista de pedidos (<?php echo $num_pedidos; ?>)</h3>
    </div>
    <div id="table_pedidos">
        <div id="header">
            <div class="id">Id</div>
            <div id="fecha">Fecha</div>
            <div>ID Cliente</div>
            <div>Cliente</div>
            <div>Status</div>
            <div>Ver detalle</div>
        </div>
        <?php foreach($pedidos as $pedido) { ?>
            <div class="row" id="<?php echo $pedido->id; ?>">
                <div class="id"><?php echo $pedido->id; ?></div>
                <div><?php echo $pedido->fecha; ?></div>
                <div><?php echo $pedido->id_cliente; ?></div>
                <div><?php echo $pedido->correo; ?></div>
                <div><?php echo $pedido->status; ?></div>
                <div>
                    <a href="pedidos_detalle.php?id=<?php echo $pedido->id; ?>">
                        <input type="button" value="Ver detalle" class="viewDetails">
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
