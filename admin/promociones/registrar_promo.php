<?php

require_once "../../config/conexion.php";

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

<form action="crear_promo.php" method="post">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre">

    <label for="descripcion">Descripción</label>
    <input type="text" name="descripcion" id="descripcion">

    <label for="precio_regular">Precio Regular</label>
    <input type="number" step="0.01" name="precio_regular" id="precio_regular" placeholder="Precio base de la promoción">

    <label for="tipo_descuento">Tipo de descuento</label>
    <select name="tipo_descuento" id="tipo_descuento">
        <option value="porcentaje">Porcentaje</option>
        <option value="monto_fijo">Monto fijo</option>
        <option value="2x1">2x1</option>
    </select>

    <label for="valor_descuento">Valor de Descuento</label>
    <input type="text" name="valor_descuento" id="valor_descuento" placeholder="Ej: 10 para 10%">

    <label for="fecha_inicio">Fecha de inicio</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio">

    <label for="fecha_fin">Fecha de fin</label>
    <input type="date" name="fecha_fin" id="fecha_fin">

    <label for="producto_id">Producto(s) en promoción</label>
    <div id="contenedor_productos">
        <div class="producto-item">
            <select name="producto_id[]" class="producto_select">
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $producto) { ?>
                    <option value="<?php echo $producto['id_producto']; ?>">
                        <?php echo $producto['nombre'] . " - $" . $producto['precio']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <button type="button" id="agregar_producto">Agregar otro producto</button>



    <script>
        document.getElementById("agregar_producto").addEventListener("click", function () {
            var contenedor = document.getElementById("contenedor_productos");
            var nuevoItem = document.createElement("div");
            nuevoItem.classList.add("producto-item");
            nuevoItem.style.marginTop = "10px";

            // Clonar el primer select
            var primerSelect = document.querySelector(".producto_select");
            var nuevoSelect = primerSelect.cloneNode(true);
            nuevoSelect.value = ""; // Resetear la selección

            // Botón para eliminar este producto
            var btnEliminar = document.createElement("button");
            btnEliminar.type = "button";
            btnEliminar.textContent = "Eliminar";
            btnEliminar.style.marginLeft = "10px";
            btnEliminar.onclick = function () {
                contenedor.removeChild(nuevoItem);
            };

            nuevoItem.appendChild(nuevoSelect);
            nuevoItem.appendChild(btnEliminar);
            contenedor.appendChild(nuevoItem);
        });
    </script>
    <button type="submit">Registrar</button>
</form>