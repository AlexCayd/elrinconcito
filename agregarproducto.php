<?php

    require './includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth) {
        header('Location: /programacion-internet/elrinconcito');
    }
    
    require './includes/config/database.php';
    $db = conectarDB();

    // Consultar para obtener origen y categorias
    $consulta_origen = "SELECT * FROM origenes ORDER BY origen;";
    $resultado_origen = mysqli_query($db, $consulta_origen);

    $consulta_categorias = "SELECT * FROM categorias ORDER BY nombre;";
    $resultado_categorias = mysqli_query($db, $consulta_categorias);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $fabricante = $_POST['fabricante'];
        $descripcion = $_POST['descripcion'];
        $origen = $_POST['origen'];
        $categoria = $_POST['categoria'];

        // Asignar fies hacia una variable
        $imagen = $_FILES['imagen'];

        // Crear la carpeta
        $carpetaImagenes = __DIR__ . '/imagenesServidor/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        // Generar un nombre único
        $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

        // Subir la imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

        // Insertar en la base de datos
        $query = "INSERT INTO productos (nombre, precio, imagen, stock, fabricante, descripcion, origen, categoria) 
        VALUES ('$nombre', '$precio', '$nombreImagen', '$stock', '$fabricante', '$descripcion', '$origen', '$categoria'); ";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Producto Agregado',
                        text: 'El producto se ha agregado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#2b2d42'
                    }).then(() => {
                        window.location.href = '/programacion-internet/elrinconcito/admin.php';
                    });
                });
            </script>";
        }        
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Rinconcito | Agregar producto</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/agregar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <main class="agregar contenedor">
        <div class="agregar__flex">
            <a href="admin.php" class="btn">Volver</a>
            <h2 class="agregar__titulo">Agregar producto</h2>
        </div>
        <form action="" method="post" class="agregar__formulario" enctype="multipart/form-data">
            <div class="agregar__campos">
                <div class="agregar__campo">
                    <label class="agregar__label">Nombre</label>
                    <input name="nombre" type="text" class="agregar__input" id="agregar__nombre" placeholder="Nombre del producto">
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Precio</label>
                    <input name="precio" type="number" class="agregar__input" id="agregar__precio" placeholder="Precio">
                </div>
                
                <div class="agregar__campo">
                    <label class="agregar__label">Stock</label>
                    <input name="stock" type="number" class="agregar__input" id="agregar__stock" placeholder="Cantidad en stock" min="1">
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Fabricante</label>
                    <input name="fabricante" type="text" class="agregar__input" id="agregar__fabricante" placeholder="Fabricante">
                </div>

                <div class="agregar__campo agregar__campo--textarea">
                    <label class="agregar__label">Descripción</label>
                    <textarea name="descripcion" id="agregarDescripcion"></textarea>
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Origen</label>
                    <select name="origen" id="agregarOrigen">
                        <option value="" selected disabled>-- Selecciona una opción --</option>
                        <?php while($origen = mysqli_fetch_assoc($resultado_origen)) :  ?>
                            <option value="<?php echo $origen['id_origen'] ?>"> <?php echo $origen['origen']; ?> </option>                        
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Categoría</label>
                    <select name="categoria" id="agregarOrigen">
                        <option value="" selected disabled>-- Selecciona una opción --</option>
                        <?php while($categoria = mysqli_fetch_assoc($resultado_categorias)) :  ?>
                            <option value="<?php echo $categoria['id_categoria'] ?>"> <?php echo $categoria['nombre']; ?> </option>                        
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Imagen</label>
                    <input name="imagen" type="file" class="agregar__imagen">
                </div>
            </div>
            <input class="agregar__submit" type="submit" value="Agregar producto">
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
    <script src="js/registrarse.js"></script>
</body>
</html>