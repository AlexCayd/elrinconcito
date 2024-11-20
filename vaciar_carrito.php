

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

$id_usuario = $_SESSION['id_usuario'];

// Consulta para vaciar el carrito del usuario
$query_delete = "DELETE FROM carrito WHERE usuario = $id_usuario";
$success = mysqli_query($db, $query_delete);

if ($success) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Carrito Vacío',
            text: 'Todos los productos han sido eliminados del carrito.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '/programacion-internet/elrinconcito/';
        });
    </script>";
    exit;
} else {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al vaciar el carrito. Por favor, intenta de nuevo.',
            icon: 'error',
            confirmButtonText: 'Cerrar'
        });
    </script>";
    exit;
}
?>