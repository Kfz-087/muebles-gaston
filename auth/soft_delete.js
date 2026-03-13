const boton_delete = document.getElementById('btn-delete');

boton_delete.addEventListener('click', soft_delete);

function soft_delete() {
    var r = confirm("¿Está seguro de desactivar el usuario?");
    if (r) {
        const id_cliente = boton_delete.getAttribute('data-id');
        fetch('/distribuidora-frami/auth/soft_delete.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                "id_cliente": id_cliente
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = "/distribuidora-frami/public/index.php";
                }
            })
            .catch(err => console.error('Error:', err));
    }
}
