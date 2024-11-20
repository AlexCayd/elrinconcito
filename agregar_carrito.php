

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Rinconcito</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="hero">
    </div>

    <footer class="footer">
        <p class="footer__descripcion">El Rinconcito &copy;. Todos los derechos reservados 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
</body>
</html>

<?php
// Importar la conexión
require './includes/config/database.php';
$db = conectarDB();

// Si no esta autenticado lo manda al index
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /programacion-internet/elrinconcito/perfil.php');
    exit;
}

// Obtener el ID del producto
$id_producto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id_producto) {
    die("Error: Producto inválido.");
}

$id_usuario = $_SESSION['id_usuario'];

// Verificar si el producto ya está en el carrito
$query_check = "SELECT cantidad FROM carrito WHERE usuario = $id_usuario AND producto = $id_producto";
$result_check = mysqli_query($db, $query_check);

if (!$result_check) {
    die("Error al verificar el producto en el carrito: " . mysqli_error($db));
}

$success = false;

if (mysqli_num_rows($result_check) > 0) {
    // Si ya existe el producto incrementa la cantidad
    $query_update = "UPDATE carrito SET cantidad = cantidad + 1 WHERE usuario = $id_usuario AND producto = $id_producto";
    $success = mysqli_query($db, $query_update);

    if (!$success) {
        die("Error al actualizar el producto en el carrito: " . mysqli_error($db));
    }
} else {
    // Si no existe el producto agrega al carrito
    $query_insert = "INSERT INTO carrito (usuario, producto, cantidad) VALUES ($id_usuario, $id_producto, 1)";
    $success = mysqli_query($db, $query_insert);

    if (!$success) {
        die("Error al insertar el producto en el carrito: " . mysqli_error($db));
    }
}

if ($success) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Producto Agregado',
            text: 'El producto se agregó correctamente al carrito.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '/programacion-internet/elrinconcito/';
        });
    </script>";
    exit;
} else {
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al agregar el producto al carrito.',
            icon: 'error',
            confirmButtonText: 'Intentar de nuevo'
        });
    </script>";
    exit;
}

?>