document.addEventListener("DOMContentLoaded", function () {
    const boton = document.getElementById("btn-categoria");
    const modal = document.getElementById("crear-categoria-modal");

    console.log("[activar_categoria] boton:", boton);
    console.log("[activar_categoria] modal:", modal);

    if (!boton) {
        console.error("[activar_categoria] ERROR: No se encontró el botón #btn-categoria");
        return;
    }
    if (!modal) {
        console.error("[activar_categoria] ERROR: No se encontró el modal #crear-categoria-modal");
        return;
    }

    const cerrar = modal.querySelector(".cerrar");
    console.log("[activar_categoria] cerrar:", cerrar);

    boton.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("[activar_categoria] Abriendo modal de CATEGORIA");
        modal.style.display = "block";
    });

    if (cerrar) {
        cerrar.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            modal.style.display = "none";
        });
    }

    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
