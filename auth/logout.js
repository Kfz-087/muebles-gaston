const boton = document.getElementById('btn-logout');

boton.addEventListener('click', logout);

function logout() {
    var r = confirm("¿Cerrar sesión?");
    if (r) {
        const usuario = boton.getAttribute('data-id');
        fetch('/distribuidora-frami/auth/logout.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                "usuario": usuario
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = "/distribuidora-frami/index.php";
                }
            })
            .catch(err => console.error('Error:', err));
    }
}