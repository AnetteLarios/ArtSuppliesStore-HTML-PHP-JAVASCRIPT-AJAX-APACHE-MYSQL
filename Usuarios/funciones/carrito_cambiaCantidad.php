<?php
require "conexionbd.php";
$con = conecta();

$producto_id = $_POST['producto_id'];
$pedido_id = $_POST['pedido_id'];
$cantidad = $_POST['cantidad'];

$sql = "UPDATE pedidos_productos SET cantidad = ? WHERE id_producto = ? AND id = ?";
$stmt = $con->prepare($sql);
if ($stmt->execute([$cantidad, $producto_id, $pedido_id])) {
    echo '1';
} else {
    echo '2';
}
?>
