<?php

require './includes/funciones.php';
$auth = estaAutenticado();

if(!$auth) {
    header('Location: /programacion-internet/elrinconcito');
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
                        <span class="header__iconos-marcador">2</span>
                        <p class="header__iconos-descripcion">Carrito</p>
                    </div>
                </div>
                <a href="micuenta.php" class="header__icono">
                    <div class="header__iconos-container">
                        <img class="header__iconos-img" src="img/header/user.svg" alt="Perfil">
                        <p class="header__iconos-descripcion">Mi Cuenta</p>
                    </div>
                </a>
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
                <div class="carrito__producto">
                    <img src="img/productos/vino1.webp" alt="Imagen en el carrito" class="carrito__imagen">
                    <div class="carrito__contenido">
                        <div class="carrito__texto">
                            <h3 class="carrito__titulo">Vino Tinto Cabernet Sauvignon (Reserva)</h3>
                            <h3 class="carrito__precio">$999.00</h3>
                        </div>
                        
                        <div class="carrito__controlador">
                            <h3 class="carrito__menos">-</h3>
                            <h3 class="carrito__cantidad">1</h3>
                            <h3 class="carrito__mas">+</h3>
                        </div>
                    </div>
                </div>

                <div class="carrito__producto">
                    <img src="img/productos/aceite1.webp" alt="Imagen en el carrito" class="carrito__imagen">
                    <div class="carrito__contenido">
                        <div class="carrito__texto">
                            <h3 class="carrito__titulo">Aceite de Oliva Extra Virgen Italiano</h3>
                            <h3 class="carrito__precio">$389.00</h3>
                        </div>
                        
                        <div class="carrito__controlador">
                            <h3 class="carrito__menos">-</h3>
                            <h3 class="carrito__cantidad">2</h3>
                            <h3 class="carrito__mas">+</h3>
                        </div>
                    </div>
                </div>

                <div class="carrito__producto">
                    <img src="img/productos/carne1.webp" alt="Imagen en el carrito" class="carrito__imagen">
                    <div class="carrito__contenido">
                        <div class="carrito__texto">
                            <h3 class="carrito__titulo">Jamón Ibérico de Bellota</h3>
                            <h3 class="carrito__precio">$649.00</h3>
                        </div>
                        
                        <div class="carrito__controlador">
                            <h3 class="carrito__menos">-</h3>
                            <h3 class="carrito__cantidad">1</h3>
                            <h3 class="carrito__mas">+</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2 class="carrito__total">Total: <span class="carrito__total-num">$1699.00</span> </h2>
            <a href="pago.php" class="carrito__pago">Continuar al pago</a>
            <a href="#" id="vaciar-carrito" class="carrito__vaciar">Vaciar Carrito</a>
        </div>
    </div>

    <main class="pago contenedor">
        <h2 class="pago__titulo">Resumen</h2>

        <h3 class="total">Total: <span class="total__num">$2426.00</span> </h3>
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
                    <tr>
                        <td>
                            <img src="img/productos/vino1.webp" class="resumen__imagen" alt="Imagen de producto">
                        </td>
                        <td>Vino Tinto Cabernet Sauvignon (Reserva)</td>
                        <td>1</td>
                        <td>$999.00</td>
                    </tr>
    
                    <tr>
                        <td>
                            <img src="img/productos/aceite1.webp" class="resumen__imagen" alt="Imagen de producto">
                        </td>
                        <td>Aceite de Oliva Extra Virgen Italiano</td>
                        <td>2</td>
                        <td>$389.00</td>
                    </tr>
    
                    <tr>
                        <td>
                            <img src="img/productos/carne1.webp" class="resumen__imagen" alt="Imagen de producto">
                        </td>
                        <td>Jamón Ibérico de Bellota</td>
                        <td>1</td>
                        <td>$649.00</td>
                    </tr>
                    
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
                    <a href="#" class="confirmacion__confirmar">Confirmar pedido</a>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
    <script src="js/iniciosesion.js"></script>
</body>
</html>