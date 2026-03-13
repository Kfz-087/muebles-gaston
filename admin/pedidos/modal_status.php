<div id="modal_status" class="modal">
    <div class="modal-content">
        <form action="new_status.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_pedido" id="input_id_pedido">

            <p>Pedido #<span id="display_id_pedido"></span></p>
            <p>Estado Actual: <span id="display_estado_actual"></span></p>
            <label for="status_pedido"> Estado:
                <select name="status" id="status_pedido">
                    <option value="">Seleccionar Estado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_preparacion">En Preparación</option>
                    <option value="en_camino">En Camino</option>
                    <option value="entregado">Entregado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </label>
            <input class="btn-primary" type="submit" value="Actualizar Estado">
        </form>
        <!-- Close button if needed, or rely on clicking outside -->
    </div>
</div>