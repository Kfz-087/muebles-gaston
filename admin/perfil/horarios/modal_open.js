document.addEventListener("DOMContentLoaded", () => {
    const boton = document.getElementById("crear_horario");
    const modal = document.getElementById("crear_horarios-modal");

    if (!boton || !modal) {
        console.error("Schedule Modal Error: Elementos no encontrados", { boton, modal });
        return;
    }

    boton.addEventListener("click", (e) => {
        e.preventDefault();
        console.log("Abriendo modal de horarios mediante clase 'is-active'");
        modal.classList.add("is-active");
    });

    const cerrar = modal.querySelector(".cerrar");
    if (cerrar) {
        cerrar.addEventListener("click", () => {
            modal.classList.remove("is-active");
        });
    }

    window.addEventListener("click", (event) => {
        if (event.target == modal) {
            modal.classList.remove("is-active");
        }
    });

    // Debug: Auto-abrir para probar si es visible (comentar después)
    // modal.classList.add("is-active");
});
