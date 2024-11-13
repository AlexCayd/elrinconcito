const openModalButton = document.getElementById('openModalButton');
const closeModalButton = document.getElementById('closeModalButton');
const modal = document.getElementById('modal');
const modalForm = document.getElementById('modalForm');

// Abrir el modal al hacer clic en el botón "Agregar"
openModalButton.addEventListener('click', (event) => {
    event.preventDefault();
    modal.style.display = 'flex';
});

// Cerrar el modal al hacer clic en el botón de cerrar
closeModalButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Cerrar el modal al hacer clic fuera del contenido
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Acción al enviar el formulario
modalForm.addEventListener('submit', (event) => {
    event.preventDefault();
    // Aquí puedes añadir la lógica para guardar el producto
    console.log("Producto guardado");
    modal.style.display = 'none'; // Cerrar el modal después de enviar el formulario
});
