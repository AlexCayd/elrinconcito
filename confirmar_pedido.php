<?php
require './includes/config/database.php';
$db = conectarDB();

require './includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('Location: /programacion-internet/elrinconcito');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Consultar los productos del carrito
$query_carrito = "
    SELECT producto, cantidad 
    FROM carrito 
    WHERE usuario = $id_usuario";

$resultado_carrito = mysqli_query($db, $query_carrito);

if (!$resultado_carrito) {
    die("Error al consultar el carrito: " . mysqli_error($db));
}

// Insertar los productos en `historial_compras` y actualizar el stock
while ($producto = mysqli_fetch_assoc($resultado_carrito)) {
    $id_producto = $producto['producto'];
    $cantidad = $producto['cantidad'];

    // Insertar en historial_compras
    $query_insert_historial = "
        INSERT INTO historial_compras (usuario, producto, cantidad) 
        VALUES ($id_usuario, $id_producto, $cantidad)";
    
    mysqli_query($db, $query_insert_historial);

    // Actualizar el stock del producto
    $query_actualizar_stock = "
        UPDATE productos 
        SET stock = stock - $cantidad 
        WHERE id_producto = $id_producto";
    
    mysqli_query($db, $query_actualizar_stock);
}


// Vaciar el carrito
$query_vaciar_carrito = "DELETE FROM carrito WHERE usuario = $id_usuario";
$resultado_vaciar = mysqli_query($db, $query_vaciar_carrito);

if (!$resultado_vaciar) {
    die("Error al vaciar el carrito: " . mysqli_error($db));
}

// Redirigir a la página de confirmación
header('Location: index.php');
exit;
?>
