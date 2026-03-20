document.addEventListener("DOMContentLoaded", () => {
    const botones = document.querySelectorAll(".btn-borrar");

    botones.forEach(boton => {
        boton.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const confirmacion = confirm("¿Estás seguro de eliminar este archivo multimedia?");
            if (!confirmacion) {
                return;
            }
            const body = JSON.stringify({
                id_multimedia: id
            });
            fetch('backend/soft_delete.php', {
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
                        alert(data.message || "Archivo eliminado correctamente.");
                        location.reload();
                    } else {
                        alert("Error: " + (data.message || "No se pudo eliminar el archivo."));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        })
    });
});
