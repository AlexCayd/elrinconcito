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

form.addEventListener('submit', (event) => {
    event.preventDefault();
    validarFormulario() 
    resultado = validarFormulario()
    if (resultado === 1) {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Creaste tu cuenta con éxito',
            showConfirmButton: true,
            confirmButtonColor: "#2b2d42"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = form.action;
            }
        });
    } 
});


function validarFormulario() {
    if (registrarseNombre == '') {
        alerta.textContent += 'No has ingresado tu nombre'
    } else {
        return true
    }
}