document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".btn-confirmar-pedido");
    const modal = document.getElementById("modal_status");
    const inputId = document.getElementById("input_id_pedido");
    const displayId = document.getElementById("display_id_pedido");
    const displayEstado = document.getElementById("display_estado_actual");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const status = this.getAttribute("data-status");

            if (inputId) {
                inputId.value = id;
                console.log("Input set to:", inputId.value);
            } else {
                console.error("Input ID element not found!");
            }

            if (displayId) displayId.textContent = id;
            if (displayEstado) displayEstado.textContent = status;

            // Open modal manually
            if (modal) {
                modal.style.display = "flex";
                console.log("Modal opened manually");
            } else {
                console.error("Modal element not found!");
            }
        });
    });

    // Close modal functionality (if not handled by Bootstrap)
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
