<div class="form-group">

    <label for="peso_producto">Peso (gr)</label>
    <input type="number" name="peso" id="peso_producto" value="${data.peso_gr}">
</div>

<div class="form-group">
    <label for="vencimiento_producto">Fecha de Vencimiento</label>
    <input type="date" name="vencimiento" id="vencimiento_producto" value="${data.fecha_vencimiento}">
</div>

<div class="form-group">
    <label for="precio_producto">Precio ($)</label>
    <input type="number" name="precio" id="precio_producto" value="${data.precio}">
</div>

<div class="form-group">
    <label for="stock_producto">Stock</label>
    <input type="number" name="stock" id="stock_producto" value="${data.stock || 0}">
</div>