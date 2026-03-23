const boton = document.getElementById('btn-logout');

if (boton) {
    boton.addEventListener('click', logout);
}

function logout() {
    var r = confirm("¿Cerrar sesión?");
    if (r) {
        const usuario = boton.getAttribute('data-id');
        fetch('/muebles-gaston/auth/logout.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                "usuario": usuario
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = "/muebles-gaston/index.php";
                }
            })
            .catch(err => console.error('Error:', err));
    }
}