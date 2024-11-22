<?php
    require './includes/funciones.php';
    $auth = estaAutenticado();

    // Importar la conexión
    require './includes/config/database.php';
    $db = conectarDB();

    if(!$auth) {
        header('Location: /programacion-internet/elrinconcito');
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

    // Obtener el historial de compras del usuario
    $query_historial = "
    SELECT hc.id_compra, p.nombre, p.imagen, hc.cantidad 
    FROM historial_compras hc 
    INNER JOIN productos p ON hc.producto = p.id_producto 
    WHERE hc.usuario = $id_usuario";

    $resultado_historial = mysqli_query($db, $query_historial);

    if (!$resultado_historial) {
    die("Error al consultar el historial de compras: " . mysqli_error($db));
    }

    // Crear un arreglo para almacenar los datos del historial
    $historial_compras = [];
    while ($compra = mysqli_fetch_assoc($resultado_historial)) {
    $historial_compras[] = $compra;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Rinconcito | Mi Perfil</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/perfil.css">
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

    <main class="perfil contenedor">
        <h2 class="perfil__titulo">Mi perfil</h2>

        <div class="perfil__grid">
            <div class="perfil__info">
                <div class="perfil__usuario">
                    <img src="img/iconos/user.svg" alt="Imagen de usuario" class="perfil__img">
                    <h3 class="perfil__nombre"><?php echo $_SESSION['nombre']; ?></h3>
                </div>
                <div class="grid__usuario">
                    <div class="usuario__campo">
                        <p class="usuario__tag usuario__tag--data">Email</p>
                        <p class="usuario__tag"><?php echo $_SESSION['email']; ?></p>
                    </div>

                    <div class="usuario__campo">
                        <p class="usuario__tag usuario__tag--data">Fecha de nacimiento</p>
                        <p class="usuario__tag"><?php echo $_SESSION['f_nacimiento']; ?></p>
                    </div>

                    <div class="usuario__campo">
                        <p class="usuario__tag usuario__tag--data">Dirección</p>
                        <p class="usuario__tag"><?php echo $_SESSION['direccion']; ?></p>
                    </div>

                    <div class="usuario__campo">
                        <p class="usuario__tag usuario__tag--data">Tarjeta bancaria</p>
                        <p class="usuario__tag"><?php echo $_SESSION['tarjeta_bancaria']; ?></p>
                    </div>

                    <form id="cerrar-sesion-form" action="cerrar_sesion.php" method="POST">
                        <button class="usuario__cerrar" type="button" id="cerrar-sesion-btn">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>

            <div class="historialu">
                <h3 class="historialu__titulo">Historial de compras</h3>
                <div class="hcompra">
                    <p class="hcompra__id">ID Compra</p>
                    <p class="hcompra__id">Imagen</p>
                    <p class="hcompra__producto">Producto</p>
                    <p class="hcompra__cantidad">Cantidad</p>
                </div>

                <?php if (count($historial_compras) > 0): ?>
                    <?php foreach ($historial_compras as $compra): ?>
                        <div class="hcompra">
                            <p class="hcompra__id"><?php echo $compra['id_compra']; ?></p>
                            <img src="imagenesServidor/<?php echo $compra['imagen']; ?>" alt="Imagen del producto" class="hcompra__img">
                            <p class="hcompra__producto"><?php echo $compra['nombre']; ?></p>
                            <p class="hcompra__cantidad"><?php echo $compra['cantidad']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No has realizado ninguna compra.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p class="footer__descripcion">El Rinconcito &copy;. Todos los derechos reservados 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
    <script src="js/iniciosesion.js"></script>
    <script>
        document.getElementById('cerrar-sesion-btn').addEventListener('click', function (e) {
            Swal.fire({
                title: '¿Quieres cerrar sesión?',
                text: "Tu sesión será cerrada.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef233c',
                cancelButtonColor: '#2b2d42',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cerrar-sesion-form').submit();
                }
            });
        });
    </script>
</body>
</html>