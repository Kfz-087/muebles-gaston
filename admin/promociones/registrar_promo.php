<?php

require_once "../config/conexion.php";

$conn = conectar();

$sql = "SELECT * FROM productos";
$registro = $conn->prepare($sql);
$registro->execute();
$productos = $registro->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM promociones";
$registro2 = $conn->prepare($sql2);
$registro2->execute();
$promociones = $registro2->fetchAll(PDO::FETCH_ASSOC);

?>

<link rel="stylesheet" href="modal_promos.css">

<div id="modal_registrar" class="modal" style="display:none">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Nueva Promoción</h3>
            <button class="close-modal" id="close-modal-btn">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="promociones/crear_promo.php" method="post" class="modal-form">
            <div class="form-group">
                <label for="nombre">Nombre de la promoción</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ej: Especial de Verano" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Corta descripción..." required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="precio_regular">Precio Regular</label>
                    <input type="number" step="0.01" name="precio_regular" id="precio_regular" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label for="tipo_descuento">Tipo</label>
                    <select name="tipo_descuento" id="tipo_descuento">
                        <option value="porcentaje">Porcentaje (%)</option>
                        <option value="monto_fijo">Monto fijo ($)</option>
                        <option value="2x1">2x1</option>
                        <option value="cuotas">Cuotas sin interés</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="valor_descuento">Valor de Descuento</label>
                <input type="text" name="valor_descuento" id="valor_descuento" placeholder="Ej: 10">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" required
                        value="<?php echo date('Y-m-d'); ?>">

                </div>
                <div class="form-group">
                    <label for="fecha_fin">Fecha de fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" required value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Producto(s) en promoción</label>
                <div id="contenedor_productos">
                    <div class="producto-item">
                        <select name="producto_id[]" class="producto_select" required>
                            <option value="">Seleccione un producto</option>
                            <?php foreach ($productos as $producto) { ?>
                                <option value="<?php echo $producto['id_producto']; ?>">
                                    <?php echo $producto['id_producto']; ?>
                                    <?php echo $producto['nombre'] . " - $" . $producto['precio']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <button type="button" id="agregar_producto" class="btn-secondary-modal">
                    <span class="material-symbols-outlined" style="font-size: 1.25rem;">add_circle</span>
                    Añadir otro producto
                </button>
            </div>

            <button type="submit" class="btn-primary-modal">Registrar Promoción</button>
        </form>
    </div>
</div>

<script>
    // JS for dynamic products is moved or kept here?
    // Let's keep the dynamic clone logic but update styles
    document.getElementById("agregar_producto").addEventListener("click", function () {
        var contenedor = document.getElementById("contenedor_productos");
        var nuevoItem = document.createElement("div");
        nuevoItem.classList.add("producto-item");
        nuevoItem.style.marginTop = "0.75rem";

        // Clonar el primer select
        var primerSelect = document.querySelector(".producto_select");
        var nuevoSelect = primerSelect.cloneNode(true);
        nuevoSelect.value = ""; // Resetear la selección

        // Botón para eliminar este producto
        var btnEliminar = document.createElement("button");
        btnEliminar.type = "button";
        btnEliminar.classList.add("btn-remove-product");
        btnEliminar.innerHTML = '<span class="material-symbols-outlined" style="font-size: 1.25rem;">delete</span>';
        btnEliminar.onclick = function () {
            contenedor.removeChild(nuevoItem);
        };

        nuevoItem.appendChild(nuevoSelect);
        nuevoItem.appendChild(btnEliminar);
        contenedor.appendChild(nuevoItem);
    });
</script>