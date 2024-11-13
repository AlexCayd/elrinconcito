const form = document.querySelector('.registrarse__formulario');
const submitButton = document.querySelector('.registrarse__submit');
const emailInput = document.getElementById('registrarse-email');
const passwordInput = document.getElementById('registrarse-password');

submitButton.classList.add('disabled');

// Validar cada vez que el usuario escribe en los campos
emailInput.addEventListener('input', validarFormulario);
passwordInput.addEventListener('input', validarFormulario);

form.addEventListener('submit', (event) => {
    event.preventDefault(); 

});

function validarFormulario() {

    if(emailInput.value !== '' && passwordInput.value.length > 0) {
        submitButton.classList.remove('disabled');
    }
}