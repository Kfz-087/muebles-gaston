const registro = document.getElementById("register-form");
const nombre = document.getElementById("nombre");
const apellido = document.getElementById("apellido");
const dni = document.getElementById("dni");
const email = document.getElementById("email");
const telefono = document.getElementById("telefono");
const direccion = document.getElementById("direccion");
const localidad = document.getElementById("localidad");
const codigo_postal = document.getElementById("codigo_postal");
const usuario = document.getElementById("nombre-usuario");
const contrasena = document.getElementById("contrasena-usuario");

registro.addEventListener("submit", (e) => {
    if (nombre.value == "" || apellido.value == "" || dni.value == "" || email.value == "" || telefono.value == "" || direccion.value == "" || localidad.value == "" || codigo_postal.value == "" || usuario.value == "" || contrasena.value == "") {
        alert("Todos los campos son obligatorios");
        return;
    }
    if (usuario.value.length < 3) {
        alert("El usuario debe tener al menos 3 caracteres");
        return;
    }
    if (contrasena.value.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres");
        return;
    }
    if (nombre.value.length < 3) {
        alert("El nombre debe tener al menos 3 caracteres");
        return;
    }
    if (apellido.value.length < 3) {
        alert("El apellido debe tener al menos 3 caracteres");
        return;
    }
    if (dni.value.length < 7) {
        alert("El DNI debe tener al menos 7 caracteres");
        return;
    }
    if (email.value.length < 3) {
        alert("El email debe tener al menos 3 caracteres");
        return;
    }
    if (telefono.value.length < 7) {
        alert("El telefono debe tener al menos 7 caracteres");
        return;
    }
    if (direccion.value.length < 3) {
        alert("La direccion debe tener al menos 3 caracteres");
        return;
    }
    if (localidad.value.length < 3) {
        alert("La localidad debe tener al menos 3 caracteres");
        return;
    }
    if (codigo_postal.value.length < 3) {
        alert("El codigo postal debe tener al menos 3 caracteres");
        return;
    }
    e.preventDefault();
    const formData = new FormData(registro);
    fetch("register.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            if (data == "success") {
                window.location.href = "../index.php";
            } else {
                console.log(data);
                alert("Error al registrar el usuario");
            }
        });
});