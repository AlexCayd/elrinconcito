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
    const botonesMas = document.querySelectorAll('.carrito__mas');
    const botonesMenos = document.querySelectorAll('.carrito__menos');

    botonesMas.forEach(boton => {
        boton.addEventListener('click', () => {
            const producto = boton.closest('.carrito__producto');
            actualizarCantidad(producto, 1);
        });
    });

    botonesMenos.forEach(boton => {
        boton.addEventListener('click', () => {
            const producto = boton.closest('.carrito__producto');
            const cantidadActual = parseInt(producto.querySelector('.carrito__cantidad').textContent);

            if (cantidadActual === 1) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Eliminarás este producto del carrito.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        actualizarCantidad(producto, -1, true);
                    }
                });
            } else {
                actualizarCantidad(producto, -1);
            }
        });
    });

    function actualizarCantidad(producto, cambio, eliminar = false) {
        const idProducto = producto.getAttribute('data-id');
        const cantidadElement = producto.querySelector('.carrito__cantidad');
        const nuevaCantidad = parseInt(cantidadElement.textContent) + cambio;

        fetch('actualizar_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ idProducto, nuevaCantidad, eliminar })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); 
            if (data.success) {
                if (eliminar) {
                    producto.remove();
                } else {
                    cantidadElement.textContent = nuevaCantidad;
                }
                actualizarTotal();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error al actualizar el carrito.', 'error');
        });

    }

    function actualizarTotal() {
        const productos = document.querySelectorAll('.carrito__producto');
        let total = 0;

        productos.forEach(producto => {
            const precio = parseFloat(producto.querySelector('.carrito__precio').textContent.replace('$', ''));
            const cantidad = parseInt(producto.querySelector('.carrito__cantidad').textContent);
            total += precio * cantidad;
        });

        document.querySelector('.carrito__total-num').textContent = `$${total.toFixed(2)}`;
    }
});