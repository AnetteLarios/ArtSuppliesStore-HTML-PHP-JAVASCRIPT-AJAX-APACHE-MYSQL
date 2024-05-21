<?php
session_start();
require "conexionbd.php";
$con = conecta();

$pedido_id = $_POST['pedido_id'];
$idCliente = $_SESSION['idCliente'];

// Obtener los productos del pedido
$sql = "SELECT pedidos_productos.id_producto, pedidos_productos.cantidad, productos.stock
        FROM pedidos_productos
        INNER JOIN productos ON pedidos_productos.id_producto = productos.id
        WHERE pedidos_productos.id = $pedido_id";
$result = $con->query($sql);

if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $producto_id = $row['id_producto'];
        $cantidad_pedido = $row['cantidad'];
        $stock_actual = $row['stock'];

        // Calcular el nuevo stock
        $nuevo_stock = $stock_actual - $cantidad_pedido;

        // Actualizar el stock en la base de datos
        $update_sql = "UPDATE productos SET stock = $nuevo_stock WHERE id = $producto_id";
        $update_result = $con->query($update_sql);

        if (!$update_result) {
            // Si hay un error al actualizar el stock, devolver un error
            echo 'Error al actualizar el stock de los productos';
            exit;
        }
    }

    // Finalizar el pedido actualizando su estado
    $update_pedido_sql = "UPDATE pedidos SET status = 1 WHERE id = $pedido_id AND id_cliente = '$idCliente' AND status = 0"; 

    if ($con->query($update_pedido_sql)) {
        echo '1'; // Éxito
    } else {
        echo '2'; // Error al finalizar el pedido
    }
} else {
    echo 'Error al obtener los productos del pedido';
}
?>
