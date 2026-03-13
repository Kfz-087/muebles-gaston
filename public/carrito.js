const carrito = document.getElementById('carrito');
const modal_carrito = document.getElementById('modal_carrito');
const cerrar_carrito = document.getElementById('cerrar_carrito');

if (carrito) {
    carrito.addEventListener("click", () => {
        if (modal_carrito) {
            modal_carrito.style.display = "block";
        }
    });
}

if (cerrar_carrito) {
    cerrar_carrito.addEventListener("click", () => {
        if (modal_carrito) modal_carrito.style.display = "none";
    });
}

// Event delegation for cart item quantity controls
if (modal_carrito) {
    modal_carrito.addEventListener('click', (e) => {
        const button = e.target.closest('.btn-qty');
        if (!button) return;

        const productId = button.getAttribute('data-id');
        const isPlus = button.classList.contains('plus');
        const cantidadChange = isPlus ? 1 : -1;

        fetch('/distribuidora-frami/public/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: productId,
                cantidad: cantidadChange
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al actualizar el carrito: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la solicitud.');
            });
    });
}

// Event delegation for "Add to Cart" buttons on product cards
document.addEventListener('click', (e) => {
    const button = e.target.closest('.btn-add-cart-sm');
    if (!button) return;

    const productId = button.getAttribute('data-id');
    // Default to 1 if data-cantidad is not present
    const cantidad = button.getAttribute('data-cantidad') || 1;

    fetch('/distribuidora-frami/public/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: productId,
            cantidad: parseInt(cantidad)
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Producto agregado al carrito!');
                location.reload();
            } else {
                alert('Error al agregar al carrito: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al procesar la solicitud. ' + error.message);
        });
});