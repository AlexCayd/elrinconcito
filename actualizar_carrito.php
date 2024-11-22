<?php

require './includes/funciones.php';
$auth = estaAutenticado();

// Importar la conexión
require './includes/config/database.php';
$db = conectarDB();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$idProducto = $data['idProducto'] ?? null;
$nuevaCantidad = $data['nuevaCantidad'] ?? null;
$eliminar = $data['eliminar'] ?? false;

$idUsuario = $_SESSION['id_usuario'] ?? null;

if (!$idUsuario || !$idProducto) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

if ($eliminar || $nuevaCantidad <= 0) {
    $query = "DELETE FROM carrito WHERE usuario = $idUsuario AND producto = $idProducto";
} else {
    $query = "UPDATE carrito SET cantidad = $nuevaCantidad WHERE usuario = $idUsuario AND producto = $idProducto";
}

$resultado = mysqli_query($db, $query);

if ($resultado) {
    // Calcular el total de ítems en el carrito
    $query_total_items = "SELECT SUM(cantidad) AS total_items FROM carrito WHERE usuario = $idUsuario";
    $resultado_total = mysqli_query($db, $query_total_items);

    $total_items = 0;
    if ($resultado_total) {
        $row = mysqli_fetch_assoc($resultado_total);
        $total_items = $row['total_items'] ?? 0;
    }

    echo json_encode([
        'success' => true,
        'total_items' => $total_items // Incluye el número total de ítems
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos']);
}

?>

