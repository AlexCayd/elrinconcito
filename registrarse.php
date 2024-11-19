<?php
    require './includes/config/database.php';
    $db = conectarDB();

    $errores = [];

    // Inicializar variables para prellenar campos
    $nombres = '';
    $apellidos = '';
    $fecha_nac = '';
    $email = '';
    $tarjeta = '';
    $direccion = '';

    $registroExitoso = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombres = mysqli_real_escape_string($db, $_POST['nombres']);
        $apellidos = mysqli_real_escape_string($db, $_POST['apellidos']);
        $fecha_nac = mysqli_real_escape_string($db, $_POST['fecha_nac']);
        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $password_conf = mysqli_real_escape_string($db, $_POST['password_conf']);
        $tarjeta = mysqli_real_escape_string($db, $_POST['tarjeta']);
        $direccion = mysqli_real_escape_string($db, $_POST['direccion']);

        if (!$nombres) {
            $errores[] = "El nombre es obligatorio.";
        }
        if (!$apellidos) {
            $errores[] = "El apellido es obligatorio.";
        }
        if (!$email) {
            $errores[] = "El email es obligatorio o no es válido.";
        }
        if (!$password) {
            $errores[] = "La contraseña es obligatoria.";
        }
        if ($password !== $password_conf) {
            $errores[] = "Las contraseñas no coinciden.";
        }
        if (!$tarjeta || !preg_match('/^\d{4}-\d{4}-\d{4}-\d{4}$/', $tarjeta)) {
            $errores[] = "El número de tarjeta bancaria es inválido. El formato es xxxx-xxxx-xxxx-xxxx";
        }
        if (!$direccion) {
            $errores[] = "La dirección es obligatoria.";
        }

        if (empty($errores)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO usuarios (nombre, email, password, f_nacimiento, tarjeta_bancaria, direccion) 
            VALUES ('$nombres $apellidos', '$email', '$passwordHash', '$fecha_nac', '$tarjeta', '$direccion')";

            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                $registroExitoso = true; 
            } else {
                $errores[] = "Hubo un error al crear la cuenta. Inténtalo de nuevo.";
            }
        }
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Rinconcito | Registrarse</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/registrarse.css">
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

    <main class="registrarse contenedor">
        <h2 class="registrarse__titulo">Registrarse</h2>
        <form action="" method="POST" class="registrarse__formulario">
            <div class="registrarse__campos">
                <div class="registrarse__campo">
                    <label class="registrarse__label">Nombre(s)</label>
                    <input name="nombres" type="text" class="registrarse__input" id="registrarse__nombre" placeholder="Nombre" value="<?php echo $nombres; ?>">
                </div>
                <div class="registrarse__campo">
                    <label class="registrarse__label">Apellidos</label>
                    <input name="apellidos" type="text" class="registrarse__input" id="registrarse__apellidos" placeholder="Apellidos" value="<?php echo $apellidos; ?>">
                </div>
                <div class="registrarse__campo">
                    <label class="registrarse__label">Fecha de nacimiento</label>
                    <input name="fecha_nac" type="date" class="registrarse__input" id="registrarse__nacimiento" value="<?php echo $fecha_nac; ?>">
                </div>
                <div class="registrarse__campo">
                    <label class="registrarse__label">Correo electrónico</label>
                    <input name="email" type="email" class="registrarse__input" id="registrarse__email" placeholder="Correo electrónico" value="<?php echo $email; ?>">
                </div>
                <div class="registrarse__campo">
                    <label class="registrarse__label">Contraseña</label>
                    <input name="password" type="password" class="registrarse__input" id="registrarse__password" placeholder="Contraseña">
                </div>
                <div class="registrarse__campo">
                    <label class="registrarse__label">Confirmar contraseña</label>
                    <input name="password_conf" type="password" class="registrarse__input" id="registrarse__confirmpassword" placeholder="Contraseña">
                </div>
                <div class="registrarse__campo">
                    <label class="registrarse__label">Número de tarjeta bancaria</label>
                    <input name="tarjeta" type="text" class="registrarse__input" id="registrarse__tarjeta" placeholder="1234-5678-1234-5678" value="<?php echo $tarjeta; ?>">
                </div>
                <div class="registrarse__campo">
                    <label class="registrarse__label">Dirección postal</label>
                    <input name="direccion" type="text" class="registrarse__input" id="registrarse__direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
                </div>
            </div>

            <?php foreach($errores as $error): ?>
                <div class="alerta">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>
            <input class="registrarse__submit" type="submit" value="Crear mi cuenta">
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
    <script>
        <?php if ($registroExitoso): ?>
        Swal.fire({
            title: '¡Registro Exitoso!',
            text: 'Tu cuenta ha sido creada exitosamente.',
            icon: 'success',
            confirmButtonColor: '#2b2d42',
            confirmButtonText: 'Continuar'
        }).then(() => {
            window.location.href = 'index.php';
        });
        <?php endif; ?>
    </script>
</body>
</html>