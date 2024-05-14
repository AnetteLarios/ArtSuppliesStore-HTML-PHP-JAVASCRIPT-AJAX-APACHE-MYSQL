<?php
//agregarProducto.php
session_start();
require "funciones/conecta.php";
$con = conecta();

//Recibe variables
$idP  = $_REQUEST['idP'];
$cant = $_REQUEST['cant'];
//
$id_cliente = $_SESSION['id_cliente'];

//Obtener id_pedido
$sql = "SELECT * FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
$res = $con->query($sql);
$num = $res->num_rows;
if ($num == 0) {
	$fecha = date(DateTimeZone);
	$sql   = "INSERT into pedidos (fecha, id_cliente)
	          VALUES ('$fecha', $id_cliente)";
	$res       = $con->query($sql);
	$id_pedido = $con->insert_id;
} else {
	
	$id_pedido = $row['id'];
}


//Obtener precio
$sql = "SELECT precio FROM productos WHERE id = $idP";
$res = $con->query($sql);
$num = $res->num_rows;
if ($num) {
	
	$precio = $row['precio'];
}


if ($cant > 0) {
	
	//Verifica si ya se esta pidiendo ese productos
	$sql = "SELECT * FROM pedidos_productos
	        WHERE id_producto = $idP AND id_pedido = $id_pedido";
	$res = $con->query($sql);
	$num = $res->num_rows;
	if ($num == 0) {
		$sql = "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad, precio)
	            VALUES ($id_pedido, $idP, $cant, $precio);";
	} else {
		$sql = "UPDATE.....   SET cantidad = cantidad + $cant  WHERE......";
	}
	$con->query($sql);
    echo 1;	
}


?>