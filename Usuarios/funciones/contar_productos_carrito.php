<?php
session_start();
$idCliente = $_SESSION['idCliente'];

if (empty($idCliente)) {
    echo '0';
    exit;
}

require "conexionbd.php";
$con = conecta();

function contarProductosCarrito($idCliente, $con) {
    $getRows = $con->prepare("SELECT COUNT(*) as total_productos
        FROM pedidos, pedidos_productos 
        WHERE pedidos.id_cliente = ? AND pedidos_productos.id = pedidos.id AND pedidos.status=0");
    $getRows->execute([$idCliente]);
    $result = $getRows->fetch(PDO::FETCH_OBJ);
    return $result->total_productos;
}

$totalProductos = contarProductosCarrito($idCliente, $con);
echo $totalProductos;
?>