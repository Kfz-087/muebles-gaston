document.addEventListener("DOMContentLoaded", function () {
    const boton = document.getElementById("crear_producto");
    const modal = document.getElementById("modal-crear");
    const content = document.getElementById("modal-crear");

    console.log("[activar_registrar] boton:", boton);
    console.log("[activar_registrar] modal:", modal);
    console.log("[activar_registrar] content:", content);

    if (!boton) {
        console.error("[activar_registrar] ERROR: No se encontró el botón #crear_producto");
        return;
    }
    if (!modal) {
        console.error("[activar_registrar] ERROR: No se encontró el modal #modal-crear");
        return;
    }

    const cerrar = modal.querySelector(".cerrar");
    console.log("[activar_registrar] cerrar:", cerrar);

    boton.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("[activar_registrar] Abriendo modal de PRODUCTO");
        modal.classList.add("is-active");
    });

    if (cerrar) {
        cerrar.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            modal.classList.remove("is-active");
        });
    }

    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.classList.remove("is-active");
        }
    });
});
