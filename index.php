<?php
    require './includes/funciones.php';
    $auth = estaAutenticado();

    // Importar la conexión
    require './includes/config/database.php';
    $db = conectarDB();

    // Consultar todos los productos
    $query = "SELECT * FROM productos ORDER BY id_producto DESC;";
    $resultado = mysqli_query($db, $query);

    $total = 0;
    $productos_carrito = [];

    if ($auth) {
        $carrito = obtenerCarrito($_SESSION['id_usuario'], $db);
        $total_items = $carrito['total_items'];
        $productos_carrito = $carrito['productos_carrito'];
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

    
    <div class="hero">
        <div class="hero__texto">
            <h2 class="hero__titulo">Transforma tu Mesa en una Experiencia Gourmet</h2>
            <p class="hero__descripcion">Disfruta de cada instante con nuestra selección gourmet de quesos, vinos y carnes. Un toque de elegancia para tus momentos especiales.</p>
        </div>
    </div>

    <div class="catalogo contenedor">
        <h2 class="catalogo__titulo">Nuestros Productos</h2>
        <p class="catalogo__descripcion">Descubre una selección gourmet diseñada para los paladares más exigentes. Desde quesos y vinos hasta carnes premium, cada producto es elegido cuidadosamente para ofrecerte calidad y autenticidad en cada bocado.</p>
        
        <div class="productos__contenedor">
        <?php while($producto = mysqli_fetch_assoc($resultado)) : ?>
            <div class="producto">
                <div class="producto__imagen">
                    <img src="imagenesServidor/<?php echo $producto['imagen']?>" alt="Producto" class="producto__img">
                    <?php 
                $rutaImagen = '';
                switch ($producto['categoria']) {
                    case 1: // Vinos
                        $rutaImagen = 'img/productos/vino.svg';
                        break;
                    case 2: // Quesos
                        $rutaImagen = 'img/productos/queso.svg';
                        break;
                    case 3: // Carnes
                        $rutaImagen = 'img/productos/comida.svg';
                        break;
                    case 4: // Aceites
                        $rutaImagen = 'img/productos/aceite.svg';
                        break;
                    default:
                        $rutaImagen = 'img/productos/default.svg'; 
                        break;
                }
            ?>
            <img src="<?php echo $rutaImagen; ?>" alt="Categoría" class="producto__icono">
                </div>
    
                <div class="producto__texto">
                    <div class="producto__flex">
                        <h3 class="producto__precio">$<?php echo $producto['precio'] ?></h3>
                        <h3 class="producto__titulo"><?php echo $producto['nombre'] ?></h3>
                    </div>
                    <p class="producto__descripcion">
                        <?php echo substr($producto['descripcion'], 0, 70) . (strlen($producto['descripcion']) > 70 ? '...' : ''); ?>
                    </p>
                    <a href="producto.php?id=<?php echo $producto['id_producto'] ?>" class="producto__vermas">Ver Más</a>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div>

    <div class="nosotros">
        <img src="img/nosotros/nosotros.webp" alt="Nosotros" class="nosotros__img">                
        <div class="nosotros__texto">
            <h2 class="nosotros__titulo">Nosotros</h2>
            <p class="nosotros__descripcion">En El Rinconcito, comenzamos con el sueño de llevar a cada mesa sabores auténticos y exclusivos. Nuestra pasión por los quesos, vinos y carnes premium nos impulsa a seleccionar lo mejor para momentos inolvidables.</p>
        </div>
    </div>
    <div id="alert-container"></div>


    <footer class="footer">
        <p class="footer__descripcion">El Rinconcito &copy;. Todos los derechos reservados 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
    <?php
    $successMessage = isset($successMessage) ? $successMessage : null;
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.dataset.successMessage = <?= json_encode($successMessage); ?>;
        });
    </script>
</body>
</html>