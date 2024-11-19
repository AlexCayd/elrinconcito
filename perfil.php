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
                </div>

                <div class="hcompra">
                    <p class="hcompra__id">016</p>
                    <img src="img/productos/aceite1.webp" alt="Imagen de Compra" class="hcompra__img">
                    <p class="hcompra__producto"> Vino Tinto Cabernet Sauvignon (Reserva)</p>
                </div>

                <div class="hcompra">
                    <p class="hcompra__id">016</p>
                    <img src="img/productos/aceite1.webp" alt="Imagen de Compra" class="hcompra__img">
                    <p class="hcompra__producto"> Vino Tinto Cabernet Sauvignon (Reserva)</p>
                </div>

                <div class="hcompra">
                    <p class="hcompra__id">016</p>
                    <img src="img/productos/aceite1.webp" alt="Imagen de Compra" class="hcompra__img">
                    <p class="hcompra__producto"> Vino Tinto Cabernet Sauvignon (Reserva)</p>
                </div>
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