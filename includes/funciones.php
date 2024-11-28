<?php

function estaAutenticado() : bool {
    session_start();

    // Verificar si la clave 'login' está definida
    $auth = isset($_SESSION['login']) ? $_SESSION['login'] : false;
    $authproducto = $_SESSION['auth'] ?? false;

    if ($auth) {
        return true;
    }

    return false;
}

function obtenerCarrito($id_usuario, $db) {
    $query_total_items = "SELECT SUM(cantidad) AS total_items FROM carrito WHERE usuario = $id_usuario";
    $resultado_total_items = mysqli_query($db, $query_total_items);
    $total_items = ($resultado_total_items) ? mysqli_fetch_assoc($resultado_total_items)['total_items'] : 0;

    $query_carrito = "
    SELECT c.cantidad, p.nombre, p.precio, p.imagen, p.id_producto 
    FROM carrito c 
    INNER JOIN productos p ON c.producto = p.id_producto 
    WHERE c.usuario = $id_usuario";
    $resultado_carrito = mysqli_query($db, $query_carrito);

    $productos_carrito = [];
    if ($resultado_carrito) {
        while ($producto = mysqli_fetch_assoc($resultado_carrito)) {
            $productos_carrito[] = $producto;
        }
    }
    return ['total_items' => $total_items, 'productos_carrito' => $productos_carrito];
}

?>

