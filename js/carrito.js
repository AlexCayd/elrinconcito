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
                        producto.remove(); 
                        actualizarCarrito(); 
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
});

document.addEventListener('DOMContentLoaded', () => {
    const botonesMas = document.querySelectorAll('.carrito__mas');

    botonesMas.forEach((boton) => {
        boton.addEventListener('click', () => {
            const productoElemento = boton.closest('.carrito__producto');
            const productoId = productoElemento.dataset.id;
            const cantidadElemento = productoElemento.querySelector('.carrito__cantidad');

            // Enviar solicitud al backend para incrementar la cantidad
            fetch('actualizar_carrito.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_producto=${productoId}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const cantidadActual = parseInt(cantidadElemento.textContent, 10);
                        cantidadElemento.textContent = cantidadActual + 1;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
