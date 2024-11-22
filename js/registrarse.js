const form = document.querySelector('.registrarse__formulario');
const submitButton = document.querySelector('.registrarse__submit');
const registrarseNombre = document.getElementById('registrarse__nombre');
const registrarseApellidos = document.getElementById('registrarse__apellidos');
const registrarseNacimiento = document.getElementById('registrarse__nacimiento');
const registrarseEmail = document.getElementById('registrarse__email');
const registrarsePassword = document.getElementById('registrarse__password');
const registrarseConfirmPassword = document.getElementById('registrarse__confirmpassword');
const registrarseTarjeta = document.getElementById('registrarse__tarjeta');
const registrarseDirección = document.getElementById('registrarse__dirección');

const alerta = document.getElementById('alerta')

// submitButton.classList.add('disabled');



function validarFormulario() {
    if (registrarseNombre == '') {
        alerta.textContent += 'No has ingresado tu nombre'
    } else {
        return true
    }
}