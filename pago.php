<?php
// Importar la conexión
require './includes/config/database.php';
$db = conectarDB();

require './includes/funciones.php';
$auth = estaAutenticado();

if(!$auth) {
    header('Location: /programacion-internet/elrinconcito');
} else {
    $id_usuario = $_SESSION['id_usuario'];
}

$total = 0;
    $productos_carrito = [];

    if ($auth) {
        // Si el usuario está autenticado, consultar el carrito
        $id_usuario = $_SESSION['id_usuario'];

        

        $query_carrito = "
        SELECT c.cantidad, p.nombre, p.precio, p.imagen, p.id_producto 
        FROM carrito c 
        INNER JOIN productos p ON c.producto = p.id_producto 
        WHERE c.usuario = $id_usuario";
    
        $resultado_carrito = mysqli_query($db, $query_carrito);

        if (!$resultado_carrito) {
            die("Error al consultar el carrito: " . mysqli_error($db));
        }

        while ($producto = mysqli_fetch_assoc($resultado_carrito)) {
            $productos_carrito[] = $producto;
            $total += $producto['precio'] * $producto['cantidad'];
        }
    }

    $total_items = 0;

    if ($auth) {
        $query_total_items = "SELECT SUM(cantidad) AS total_items FROM carrito WHERE usuario = $id_usuario";
        $resultado_total_items = mysqli_query($db, $query_total_items);

        if ($resultado_total_items) {
            $row = mysqli_fetch_assoc($resultado_total_items);
            $total_items = $row['total_items'] ?? 0;
        }
    }

// Consultar los productos del carrito
$query_carrito = "
    SELECT 
        carrito.cantidad, 
        productos.nombre, 
        productos.precio, 
        productos.imagen 
    FROM 
        elrinconcito.carrito 
    INNER JOIN 
        elrinconcito.productos 
    ON 
        carrito.producto = productos.id_producto 
    WHERE 
        carrito.usuario = $id_usuario";
$resultado_carrito = mysqli_query($db, $query_carrito);

if (!$resultado_carrito) {
    die("Error al consultar el carrito: " . mysqli_error($db));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Rinconcito | Confirmación de pedido</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/pago.css">
</head>
<body>
<header class="header">
        <div class="header__contenedor">
            <h2 class="header__logo">El Rinconcito</h2>
            <div class="header__iconos">
                <a href="index.php" class="header__icono">
                    <div class="header__iconos-container">
                        <img class="header__iconos-img" src="img/header/home.svg" alt="Inicio">
                        <p class="header__iconos-descripcion">Home</p>
                    </div>
                </a>
                <div class="header__icono" id="cartIcon">
                    <div class="header__iconos-container">
                        <img class="header__iconos-img" src="img/header/cart.svg" alt="Carrito">
                        <span class="header__iconos-marcador"><?php echo $total_items; ?></span>
                        <p class="header__iconos-descripcion">Carrito</p>
                    </div>
                </div>
                <?php 
                    if (!$auth) {
                        echo '<a href="micuenta.php" class="header__icono">
                                <div class="header__iconos-container">
                                    <img class="header__iconos-img" src="img/header/user.svg" alt="Perfil">
                                    <p class="header__iconos-descripcion">Iniciar Sesión</p>
                                </div>
                            </a>';
                    } else {
                        echo '<a href="perfil.php" class="header__icono">
                                <div class="header__iconos-container">
                                    <img class="header__iconos-img" src="img/header/user.svg" alt="Perfil">
                                    <p class="header__iconos-descripcion">Mi Perfil</p>
                                </div>
                            </a>';
                    }
                ?>
            </div>
        </div>
    </header>

    <div class="sidebar" id="cartSidebar">
        <div class="sidebar__contenido">
            <div class="sidebar__flex">
                <h2 class="sidebar__titulo">Tu Carrito</h2>
                <button class="sidebar__close" id="closeSidebar">x</button>
            </div>
            <div class="carrito__productos">
                <?php if (count($productos_carrito) > 0): ?>
                    <?php foreach ($productos_carrito as $producto): ?>
                    <div class="carrito__producto" data-id="<?php echo $producto['id_producto']; ?>">
                    <img src="imagenesServidor/<?php echo $producto['imagen']; ?>" alt="Imagen del producto" class="carrito__imagen">
                    <div class="carrito__contenido">
                        <div class="carrito__texto">
                            <h3 class="carrito__titulo"><?php echo $producto['nombre']; ?></h3>
                            <h3 class="carrito__precio">$<?php echo number_format($producto['precio'], 2); ?></h3>
                        </div>
                        <div class="carrito__controlador">
                            <h3 class="carrito__menos">-</h3>
                            <h3 class="carrito__cantidad"><?php echo $producto['cantidad']; ?></h3>
                            <h3 class="carrito__mas">+</h3>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay productos en el carrito.</p>
                <?php endif; ?>
            </div>
            <h2 class="carrito__total">Total: <span class="carrito__total-num">$<?php echo number_format($total, 2); ?></span></h2>
            <div class="confirmacion__boton">
                <a href="pago.php" class="carrito__pago">Continuar al pago</a>
            </div>

            <a href="vaciar_carrito.php" id="vaciar-carrito" class="carrito__vaciar">Vaciar Carrito</a>
        </div>
    </div>

    <main class="pago contenedor">
        <h2 class="pago__titulo">Resumen</h2>

        <h3 class="total">Total: <span class="total__num">$<?php echo number_format($total, 2); ?></span> </h3>
        <div class="pago__contenedor">
        <table class="resumen">
            <thead class="resumen__encabezado">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody class="resumen__productos">
                <?php while ($producto = mysqli_fetch_assoc($resultado_carrito)) : ?>
                    <tr>
                        <td>
                            <img src="imagenesServidor/<?php echo $producto['imagen']; ?>" class="resumen__imagen" alt="Imagen de producto">
                        </td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>


            <div class="confirmacion">
                <h2 class="confirmacion__titulo">Datos de pago</h2>
                <img src="img/iconos/user.svg" alt="Imagen de usuario" class="pago__img">
                <div class="confirmacion__mapa">
                    <h3 class="confirmacion__subtitulo">Nombre</h3>
                    <p class="confirmacion__direcion"><?php echo $_SESSION['nombre']; ?></p>
                    <h3 class="confirmacion__subtitulo">Dirección de entrega</h3>
                    <p class="confirmacion__direcion"><?php echo $_SESSION['direccion']; ?></p>
                </div>
                <div class="confirmacion__metodopago">
                    <h3 class="confirmacion__subtitulo">Método de pago</h3>
                    <div class="confirmacion__tarjeta">
                        <p class="confirmacion__tarjeta-numeros"><?php echo $_SESSION['tarjeta_bancaria']; ?></p>
                    </div>
                </div>
                <div class="confirmacion__boton">
                    <a href="confirmar_pedido.php" class="confirmacion__confirmar">Confirmar pedido</a>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
    <script src="js/iniciosesion.js"></script>
</body>
</html>