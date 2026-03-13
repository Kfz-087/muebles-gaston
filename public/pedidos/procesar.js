const confirmarPedido = document.getElementById('confirmar-pedido');

if (confirmarPedido) {
    confirmarPedido.addEventListener('click', () => {
        const idCliente = confirmarPedido.getAttribute('data-id-cliente');
        const sucursalSelect = document.getElementById('sucursal');
        const idSucursal = sucursalSelect ? sucursalSelect.value : null;

        if (!idSucursal) {
            alert('Por favor, selecciona una sucursal.');
            return;
        }

        fetch('../pedidos/procesar_pedido.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id_cliente: idCliente,
                id_sucursal: idSucursal
            })
        })
            .then(response => response.text()) // Get text first
            .then(text => {
                console.log('Raw response:', text); // Debug log
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error('Server returned invalid JSON: ' + text);
                }
            })
            .then(data => {
                if (data.success) {
                    alert('Pedido confirmado!');
                    localStorage.removeItem('carrito');
                    location.reload();
                } else {
                    alert('Error al confirmar el pedido: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la solicitud. Revise la consola para más detalles.');
            });
    });
}