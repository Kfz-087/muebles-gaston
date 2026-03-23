<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== '1') {
    header("Location: ../../index.php");
    exit;
}

$id_producto = $_GET['id_producto'];
require_once __DIR__ . '/../../config/conexion.php';
$conn = conectar();
$consulta = $conn->prepare("SELECT * FROM productos WHERE id_producto= :id_producto");
$consulta->execute([
    ':id_producto' => $id_producto
]);
$producto = $consulta->fetch(PDO::FETCH_ASSOC);
?>

<div class="modal-content" style="display: none;">
    <form action="actualizar_producto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
        <label for="nombre_producto"> Nombre:
            <input type="text" name="nombre" id="nombre_producto" value="<?php echo $producto['nombre']; ?>">
        </label>

        <label for="peso_producto(gr)"> Peso (gr):
            <input type="number" name="peso" id="peso_producto" value="<?php echo $producto['peso_gr']; ?>">
        </label>

        <label for="vencimiento_producto"> Fecha de Vencimiento:
            <input type="date" name="vencimiento" id="vencimiento_producto"
                value="<?php echo $producto['fecha_vencimiento']; ?>">
        </label>

        <label for="descripcion_producto"> Descripción:
            <input type="text" name="descripcion" id="descripcion_producto"
                value="<?php echo $producto['descripcion']; ?>">
        </label>

        <label for="precio_producto"> Precio:
            <input type="number" name="precio" id="precio_producto" value="<?php echo $producto['precio']; ?>">
        </label>

        <label for="stock_producto"> Stock:
            <select name="stock" id="stock_producto" value="<?php echo $producto['stock']; ?>">
                <option value="">Seleccionar Stock</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </label>


        <label for="categoria_producto"> Categoria:
            <label for="stock_producto"> Stock:
                <input type="number" name="stock" id="stock_producto" value="<?php echo $producto['stock']; ?>"
                    required>

            </label>
        </label>

        <label for=" imagen_producto"> Imagen:
            <input type="file" name="imagen" id="imagen_producto">
        </label>

        <button type="submit">Crear Producto</button>
    </form>
</div>

<script src="../../auth/logout.js"></script>