console.log("[activar_registrar] El archivo script ha sido ejecutado por el navegador.");

document.addEventListener("DOMContentLoaded", function () {
    console.log("[activar_registrar] Ejecutando inicialización del modal de creación.");

    const botonesRegistrar = document.querySelectorAll(".btn-abrir-modal-registro");
    const modal = document.getElementById("modal-crear");

    console.log("[activar_registrar] Botones encontrados:", botonesRegistrar.length);
    if (botonesRegistrar.length === 0) {
        console.warn("[activar_registrar] No se encontraron elementos con la clase .btn-abrir-modal-registro");
    }

    if (!modal) {
        console.error("[activar_registrar] ERROR: No se encontró el modal #modal-crear");
        return;
    }

    const cerrar = modal.querySelector(".cerrar");

    function openModal(e) {
        console.log("[activar_registrar] Abriendo modal...");
        e.preventDefault();
        e.stopPropagation();
        modal.classList.add("is-active");
        modal.style.display = "block";
    }

    // Usar delegación en el body por si los botones se renderizan dinámicamente o hay conflictos
    document.body.addEventListener("click", function (e) {
        if (e.target.closest(".btn-abrir-modal-registro")) {
            openModal(e);
        }
    });

    if (cerrar) {
        cerrar.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            modal.classList.remove("is-active");
            modal.style.display = "none";
        });
    }

    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.classList.remove("is-active");
            modal.style.display = "none";
        }
    });
});
