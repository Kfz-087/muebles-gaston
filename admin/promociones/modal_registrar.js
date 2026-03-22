const boton = document.getElementById('crear_promocion');
const modal = document.getElementById('modal_registrar');
const closeBtn = document.getElementById('close-modal-btn');

boton.addEventListener('click', () => {
    modal.style.display = 'flex'; // Changed to flex to use backdrop styles
});

closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

