<?php
session_start();
require_once "conexionbd.php";
$con = conecta();

date_default_timezone_set('America/Mexico_City');

if (!isset($_POST['producto_id'], $_POST['stock'], $_POST['costo'], $_POST['deseados'])) {
    echo "Error: Datos de producto no recibidos correctamente.";
    exit;
}

$producto_id = $_POST['producto_id'];
$stock = $_POST['stock'];
$costo = $_POST['costo'];
$deseados = $_POST['deseados'];

if (!isset($_SESSION['idCliente']) || empty($_SESSION['idCliente'])) {
    echo "Error: Sesión de cliente no configurada correctamente.";
    exit;
}

$id_cliente = $_SESSION['idCliente'];
$status = 0;

$pedido_id = -1;

$sql = "SELECT * FROM pedidos WHERE id_cliente='$id_cliente' AND status = 0"; 
$res = $con->query($sql);

if ($res && $res->rowCount() == 1) {
    $pedido = $res->fetch(PDO::FETCH_ASSOC);
    $pedido_id = $pedido['id'];
} else {
    $fecha = date("Y-m-d H:i:s");
    $sql = "INSERT INTO pedidos (fecha, id_cliente, status) VALUES ('$fecha', '$id_cliente', $status) ";
    $res = $con->query($sql);
    if (!$res) {
        echo "Error al crear un nuevo pedido: " . $con->errorInfo();
        exit;
    }
    $pedido_id = $con->lastInsertId();
}

if ($pedido_id > 0) {
    $sql = "SELECT * FROM pedidos_productos WHERE id = $pedido_id AND id_producto = $producto_id"; 
    $res = $con->query($sql);
    
    if ($res && $res->rowCount() >= 1) {
        $producto_en_carrito = $res->fetch(PDO::FETCH_ASSOC);
        $cantidad_actual = $producto_en_carrito['cantidad'];
        $nueva_cantidad = $cantidad_actual + $deseados;

        $sql = "UPDATE pedidos_productos SET cantidad = $nueva_cantidad WHERE id_producto = $producto_id AND id = $pedido_id"; 
        $res = $con->query($sql);
        if (!$res) {
            echo "Error al actualizar la cantidad del producto en el carrito: " . $con->errorInfo();
            exit;
        }
        $resultado = '1'; // Producto actualizado en el carrito
    } else {
        $sql = "INSERT INTO pedidos_productos (id, id_producto, cantidad, precio) VALUES ($pedido_id, $producto_id, $deseados, $costo) ";
        $res = $con->query($sql);
        if (!$res) {
            echo "Error al agregar el producto al carrito: " . $con->errorInfo();
            exit;
        }
        $resultado = '2'; // Producto añadido al carrito
    }
} else {
    $resultado = '0'; // Error al obtener el pedido
}

echo $resultado;
?>