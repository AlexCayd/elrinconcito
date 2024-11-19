<?php

require './includes/funciones.php';
$auth = estaAutenticado();

if(!$auth) {
    header('Location: /programacion-internet/elrinconcito');
}

// Validar URL válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: ../elrinconcito');
    exit;
}

require './includes/config/database.php';
$db = conectarDB();

// Consulta para los datos del producto
$consultaProducto = "SELECT * FROM productos WHERE id_producto = ${id};";
$resultadoProducto = mysqli_query($db, $consultaProducto);

// Validar que el producto exista
if (!$resultadoProducto || mysqli_num_rows($resultadoProducto) === 0) {
    header('Location: ../elrinconcito');
    exit;
}

$producto = mysqli_fetch_assoc($resultadoProducto);

// Consultar para obtener origen y categorías
$consulta_origen = "SELECT * FROM origenes;";
$resultado_origen = mysqli_query($db, $consulta_origen);

$consulta_categorias = "SELECT * FROM categorias;";
$resultado_categorias = mysqli_query($db, $consulta_categorias);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $fabricante = $_POST['fabricante'];
    $descripcion = $_POST['descripcion'];
    $origen = $_POST['origen'];
    $categoria = $_POST['categoria'];

    // Manejo de imágenes
    $imagen = $_FILES['imagen'];
    $carpetaImagenes = __DIR__ . '/imagenesServidor/';
    if (!is_dir($carpetaImagenes)) {
        mkdir($carpetaImagenes);
    }

    $nombreImagen = $producto['imagen'];

    if($imagen['name']) {
        // Eliminar la imagen previa
        unlink($carpetaImagenes . $producto['imagen']);
    }



    if ($imagen['name']) {
        $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
    }

    // Actualizar en la base de datos
    $query = "UPDATE productos SET 
        nombre = '$nombre',
        precio = '$precio',
        stock = '$stock',
        fabricante = '$fabricante',
        descripcion = '$descripcion',
        origen = '$origen',
        categoria = '$categoria',
        imagen = '$nombreImagen'
        WHERE id_producto = ${id};";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Producto Actualizado",
                    text: "El producto se ha actualizado correctamente.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#2b2d42"
                }).then(() => {
                    window.location.href = "/programacion-internet/elrinconcito/admin.php";
                });
            });
        </script>';
    } else {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Error",
                    text: "Hubo un error al actualizar el producto.",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#2b2d42"
                });
            });
        </script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Rinconcito | Editar producto</title>
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
            <h2 class="agregar__titulo">Editar producto</h2>
        </div>
        <form action="" method="post" class="agregar__formulario" enctype="multipart/form-data">
            <div class="agregar__campos">
                <div class="agregar__campo">
                    <label class="agregar__label">Nombre</label>
                    <input value="<?php echo $producto['nombre'] ?>" name="nombre" type="text" class="agregar__input" id="agregar__nombre" placeholder="Nombre del producto">
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Precio</label>
                    <input value="<?php echo $producto['precio'] ?>" name="precio" type="number" class="agregar__input" id="agregar__precio" placeholder="Precio">
                </div>
                
                <div class="agregar__campo">
                    <label class="agregar__label">Stock</label>
                    <input value="<?php echo $producto['stock'] ?>" name="stock" type="number" class="agregar__input" id="agregar__stock" placeholder="Cantidad en stock" min="1">
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Fabricante</label>
                    <input value="<?php echo $producto['fabricante'] ?>" name="fabricante" type="text" class="agregar__input" id="agregar__fabricante" placeholder="Fabricante">
                </div>

                <div class="agregar__campo agregar__campo--textarea">
                    <label class="agregar__label">Descripción</label>
                    <textarea placeholder="<?php echo $producto['descripcion'] ?>" name="descripcion" id="agregarDescripcion"><?php echo $producto['descripcion'] ?></textarea>
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Origen</label>
                    <select name="origen" id="agregarOrigen">
                        <option value="" disabled>-- Selecciona una opción --</option>
                        <?php while($origen = mysqli_fetch_assoc($resultado_origen)) :  ?>
                            <option 
                                value="<?php echo $origen['id_origen']; ?>" 
                                <?php echo $producto['origen'] == $origen['id_origen'] ? 'selected' : ''; ?>>
                                <?php echo $origen['origen']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Categoría</label>
                    <select name="categoria" id="agregarCategoria">
                        <option value="" disabled>-- Selecciona una opción --</option>
                        <?php while($categoria = mysqli_fetch_assoc($resultado_categorias)) :  ?>
                            <option 
                                value="<?php echo $categoria['id_categoria']; ?>" 
                                <?php echo $producto['categoria'] == $categoria['id_categoria'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="agregar__campo">
                    <label class="agregar__label">Imagen</label>
                    <input name="imagen" type="file" class="agregar__imagen">
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="imagenesServidor/<?php echo $producto['imagen']; ?>" alt="Imagen del producto" class="agregar__imagen-previsualizacion">
                    <?php endif; ?>
                </div>
            </div>
            <input class="agregar__submit" type="submit" value="Editar producto">
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
    <script src="js/registrarse.js"></script>
</body>
</html>