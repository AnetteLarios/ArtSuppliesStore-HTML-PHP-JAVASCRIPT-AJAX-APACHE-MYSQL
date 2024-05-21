<?php
require "conexionbd.php";
$con = conecta();

$producto_id = $_POST['producto_id'];
$pedido_id = $_POST['pedido_id'];

$sql = "DELETE FROM pedidos_productos WHERE id_producto = ? AND id = ?";
$stmt = $con->prepare($sql);
if ($stmt->execute([$producto_id, $pedido_id])) {
    echo '1';
} else {
    echo '2';
}
?>
