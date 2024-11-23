<?php
    // Iniciar sesión
    session_start();

    // Verificar si el usuario está autenticado
    $auth = $_SESSION['auth'] ?? false;
    
    // Importar la conexión
    require './includes/config/database.php';
    $db = conectarDB();

    $id = $_GET['id'] ?? null;
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: index.php'); 
        exit;
    }

    // Consultar los datos del producto
    $query = "SELECT * FROM productos WHERE id_producto = ${id};";
    $resultado = mysqli_query($db, $query);

    if (!$resultado) {
        die("Error al consultar el producto: " . mysqli_error($db));
    }

    $producto = mysqli_fetch_assoc($resultado);

    $total_items = 0;
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

        if ($resultado_carrito) {
            while ($producto = mysqli_fetch_assoc($resultado_carrito)) {
                $productos_carrito[] = $producto;
                $total += $producto['precio'] * $producto['cantidad'];
            }
        }

        // Calcular el total de items en el carrito
        $query_total_items = "SELECT SUM(cantidad) AS total_items FROM carrito WHERE usuario = $id_usuario";
        $resultado_total_items = mysqli_query($db, $query_total_items);

        if ($resultado_total_items) {
            $row = mysqli_fetch_assoc($resultado_total_items);
            $total_items = $row['total_items'] ?? 0;
        }
    }

?>


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
    <link rel="stylesheet" href="styles/producto.css">
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

    <main class="productos contenedor">
        <img src="imagenesServidor/<?php echo $producto['imagen'] ?>" alt="Imagen de productos" class="productos__imagen">

        <div class="productos__texto">
            <a href="index.php" class="productos__atras">
                <img class="productos__atras-img" src="img/iconos/atras.svg" alt="Flecha atrás">
                Volver
            </a>
            <h2 class="productos__titulo"><?php echo $producto['nombre']; ?></h2>
            <h3 class="productos__precio">$<?php echo $producto['precio']; ?></h3>
            <p class="productos__descripcion"><?php echo $producto['descripcion']; ?></p>
            <a href="agregar_carrito.php?id=<?php echo $producto['id_producto']; ?>" class="productos__agregar">
                Agregar al Carrito
                <img src="img/iconos/agregar.svg" alt="Agregar" class="productos__agregar-icono">
            </a>
        </div>
    </main>

    <footer class="footer">
        <p class="footer__descripcion">El Rinconcito &copy;. Todos los derechos reservados 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
</body>
</html>