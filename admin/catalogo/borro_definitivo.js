document.addEventListener("DOMContentLoaded", () => {
    const botones = document.querySelectorAll(".btn-definitivo");

    botones.forEach(boton => {
        boton.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const confirmacion = confirm("¿Estás seguro de eliminar este producto?");
            if (!confirmacion) {
                return;
            }
            const body = JSON.stringify({
                id_producto: id
            });
            fetch('borro_definitivo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: body,
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data && data.status === "success") {
                        alert(data.message || "Producto eliminado correctamente.");
                        location.reload();
                    } else {
                        alert("Error: " + (data.message || "No se pudo eliminar el producto."));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        })
    });
});
