const cartIcon = document.getElementById('cartIcon');
const closeSidebar = document.getElementById('closeSidebar');
const cartSidebar = document.getElementById('cartSidebar');

cartIcon.addEventListener('click', () => {
    cartSidebar.style.right = '0';
});

closeSidebar.addEventListener('click', () => {
    cartSidebar.style.right = '-100%';
});

document.addEventListener('DOMContentLoaded', () => {
    const marcadorCarrito = document.querySelector('.header__iconos-marcador');
    const totalCarritoElement = document.querySelector('.carrito__total-num');

    function actualizarCarrito() {
        let cantidadTotalProductos = 0;
        let totalCarrito = 0;

        document.querySelectorAll('.carrito__producto').forEach(producto => {
            const cantidad = parseInt(producto.querySelector('.carrito__cantidad').textContent, 10);
            const precio = parseFloat(producto.querySelector('.carrito__precio').textContent.replace('$', ''));

            cantidadTotalProductos += cantidad;
            totalCarrito += cantidad * precio;
        });

        marcadorCarrito.textContent = cantidadTotalProductos || '0';
        marcadorCarrito.style.display = cantidadTotalProductos > 0 ? 'inline-block' : 'none';
        // Para que el formato del total sea con dos decimales
        totalCarritoElement.textContent = `$${totalCarrito.toFixed(2)}`;
    }

    actualizarCarrito();

    // Event listeners para los botones de aumentar y disminuir cantidad
    document.querySelectorAll('.carrito__producto').forEach(producto => {
        const botonMenos = producto.querySelector('.carrito__menos');
        const botonMas = producto.querySelector('.carrito__mas');
        const cantidadElement = producto.querySelector('.carrito__cantidad');

        botonMenos.addEventListener('click', () => {
            let cantidad = parseInt(cantidadElement.textContent, 10);
            
            if (cantidad === 1) {
                // Mostrar alerta de confirmación para eliminar el producto
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: '¿Quieres eliminar este producto?',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonColor: '#ef233c',
                    cancelButtonColor: '#2b2d42',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        producto.remove(); // Eliminar el producto del DOM
                        actualizarCarrito(); // Actualizar el carrito después de la eliminación
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Producto eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            } else {
                // Decrementar la cantidad si es mayor que 1
                cantidad -= 1;
                cantidadElement.textContent = cantidad;
                actualizarCarrito();
            }
        });

        botonMas.addEventListener('click', () => {
            let cantidad = parseInt(cantidadElement.textContent, 10);
            cantidad += 1;
            cantidadElement.textContent = cantidad;
            actualizarCarrito();
        });
    });

    document.querySelector('#vaciar-carrito').addEventListener('click', () => {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: '¿En serio quieres vaciar el carrito?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#ef233c',
            cancelButtonColor: '#2b2d42',
            confirmButtonText: 'Sí, vaciar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('.carrito__productos').innerHTML = ''; 
                actualizarCarrito(); 
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Carrito vaciado',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });
});
