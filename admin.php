<?php

require './includes/funciones.php';
$auth = estaAutenticado();

if(!$auth) {
    header('Location: /programacion-internet/elrinconcito');
}

// Importar la conexión
require './includes/config/database.php';
$db = conectarDB();

// Consultar todos los productos
$query = "SELECT * FROM productos ORDER BY id_producto DESC;";
$resultado = mysqli_query($db, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        // Consulta para obtener la imagen del producto
        $queryImagen = "SELECT imagen FROM productos WHERE id_producto = ${id};";
        $resultadoImagen = mysqli_query($db, $queryImagen);

        if ($resultadoImagen) {
            $imagen = mysqli_fetch_assoc($resultadoImagen);
            if ($imagen && file_exists('imagenesServidor/' . $imagen['imagen'])) {
                unlink('imagenesServidor/' . $imagen['imagen']);
            }
        }

        // Consulta para eliminar el producto
        $queryEliminar = "DELETE FROM productos WHERE id_producto = ${id};";
        $resultadoEliminar = mysqli_query($db, $queryEliminar);

        if ($resultadoEliminar) {
            header('Location: admin.php?eliminado=true');
            exit;
        }
    }
}

// Obtener el historial de compras del usuario
$query_historial = "
SELECT hc.id_compra, u.nombre AS cliente, p.nombre AS producto, p.imagen, hc.cantidad 
FROM historial_compras hc 
INNER JOIN productos p ON hc.producto = p.id_producto
INNER JOIN usuarios u ON hc.usuario = u.id_usuario";


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
    <title>El Rinconcito | Panel de Administración</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/admin.css">
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

    <div class="admin contenedor">
        <div class="admin__flex">
            <h2 class="admin__titulo">Productos</h2>
            <a href="agregarproducto.php" class="admin__agregar">Agregar</a>
        </div>

        <table class="productos">
            <thead class="admin__encabezado">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Botones</th>
                </tr>
            </thead>
        
            <tbody class="admin__productos">
                <?php while($producto = mysqli_fetch_assoc($resultado)) : ?>
                    <tr>
                        <td data-label="Imagen">
                            <img src="imagenesServidor/<?php echo $producto['imagen'] ?>" class="admin__imagen" alt="Imagen de producto">
                        </td>
                        <td data-label="Producto"><?php echo $producto['nombre'] ?></td>
                        <td data-label="Stock"><?php echo $producto['stock'] ?></td>
                        <td data-label="Precio"><?php echo $producto['precio'] ?></td>
                        <td data-label="Descripcion"><?php echo $producto['descripcion'] ?></td>
                        <td class="admin__btns">
                            <a href="editarproducto.php?id=<?php echo $producto['id_producto'] ?>" class="admin__btn admin__btn--editar">
                                <img src="img/iconos/editar.svg" alt="Icono editar" class="mobile__icono">
                                Editar
                            </a>
                            <button 
                                type="button" 
                                class="admin__btn admin__btn--eliminar" 
                                data-id="<?php echo $producto['id_producto']; ?>">
                                <img src="img/iconos/eliminar.svg" alt="Eliminar" class="mobile__icono">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>

        <div class="mobile">
        <?php mysqli_data_seek($resultado, 0); ?>
            <?php while($producto = mysqli_fetch_assoc($resultado)) : ?>
                <div class="mobile__producto">
                    <div class="mobile__imagen">
                        <img src="imagenesServidor/<?php echo $producto['imagen'] ?>" alt="Producto" class="mobile__img">
                    </div>
                    <div class="mobile__texto">
                        <h2 class="mobile__titulo"><?php echo $producto['nombre'] ?></h3>
                        <div class="mobile__flex">
                            <h3 class="mobile__stock">Stock: <span class="mobile__stock-num"><?php echo $producto['stock'] ?></span> </h3>
                            <h3 class="mobile__precio">Precio: <?php echo $producto['precio'] ?></h3>
                        </div>
                        <p class="mobile__descripcion"><?php echo $producto['descripcion'] ?></p>
                    </div>
                    <div class="mobile__botones">
                        <a href="editarproducto.php?id=<?php echo $producto['id_producto'] ?>" class="admin__btn admin__btn--editar mobile__btn">
                            <img src="img/iconos/editar.svg" alt="Icono editar" class="mobile__icono">
                        </a>
                        <form method="POST">
                            <button type="submit" class="admin__btn admin__btn--eliminar">
                                <img src="img/iconos/eliminar.svg" alt="Eliminar" class="mobile__icono">
                            </button>
                        </form>
                    </div>
                </div>
            <?php endwhile ?>
        </div>
    </div>

    <div class="historialu contenedor">
        <h3 class="historialu__titulo">Historial de compras</h3>
        <div class="hcompra hcompra-admin">
            <p class="hcompra__id">ID Compra</p>
            <p class="hcompra__id">Cliente</p>
            <p class="hcompra__id">Imagen</p>
            <p class="hcompra__producto">Producto</p>
            <p class="hcompra__cantidad">Cantidad</p>
        </div>

        <?php if (count($historial_compras) > 0): ?>
            <?php foreach ($historial_compras as $compra): ?>
                <div class="hcompra hcompra-admin">
                    <p class="hcompra__id"><?php echo $compra['id_compra']; ?></p>
                    <p class="hcompra__id"><?php echo $compra['cliente']; ?></p>
                    <img src="imagenesServidor/<?php echo $compra['imagen']; ?>" alt="Imagen del producto" class="hcompra__img">
                    <p class="hcompra__producto"><?php echo $compra['producto']; ?></p>
                    <p class="hcompra__cantidad"><?php echo $compra['cantidad']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay compras registradas.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/carrito.js"></script>
    <script src="js/iniciosesion.js"></script>
    <script src="js/admin.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.admin__btn--eliminar').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás revertir esta acción',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef233c',
                    cancelButtonColor: '#2b2d42',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(result => {
                    if (result.isConfirmed) {
                        // Crear un formulario y enviarlo
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '';
                        form.innerHTML = `<input type="hidden" name="id" value="${id}">`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });

        // Mostrar alerta de éxito si el producto fue eliminado
        if (new URLSearchParams(window.location.search).get('eliminado') === 'true') {
            Swal.fire({
                title: 'Producto Eliminado',
                text: 'El producto fue eliminado correctamente.',
                icon: 'success',
                confirmButtonColor: '#2b2d42',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = window.location.pathname;
            });
        }
    });

    </script>
</body>
</html>

<?php
    mysqli_close($db);
?>