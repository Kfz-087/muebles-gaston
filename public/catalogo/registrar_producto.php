<div id="modal-crear" class="modal-editar">
    <div class="modal-content">
        <h3 class="modal-title"> Crear Producto</h3>
        <form action="crear_producto.php" method="post" id="crear-producto-modal" enctype="multipart/form-data">

            <span class="cerrar">&times;</span>

            <div class="form-wrapper">

                <div class="form-group">
                    <label for="nombre_producto"> Nombre:
                        <input type="text" class="modificar" name="nombre" id="nombre_producto" required>
                    </label>
                </div>

                <!-- <div class="form-group">
                    <label for="peso_producto(gr)"> Peso (gr):
                        <input type="number" name="peso" id="peso_producto">
                    </label>
                </div> -->

                <!-- <div class="form-group">
                    <label for="vencimiento_producto"> Fecha de Vencimiento:
                        <input type="date" name="vencimiento" id="vencimiento_producto">
                    </label>
                </div> -->

                <div class="form-group">
                    <label for="descripcion_producto"> Descripción:
                        <input type="text" class="modificar" name="descripcion" id="descripcion_producto">
                    </label>
                </div>

                <!-- <div class="form-group">
                    <label for="precio_producto"> Precio:
                        <input type="number" class="modificar" name="precio" id="precio_producto" required>
                    </label>
                </div> -->

                <!-- <div class="form-group">
                    <label for="stock_producto"> Stock:
                        <input type="number" name="stock" id="stock_producto" required>
                    </label>
                </div> -->

                <?php
                require_once __DIR__ . '/../../config/conexion.php';
                $conn = conectar();
                $consulta = $conn->prepare("SELECT * FROM categoria");
                $consulta->execute();
                $categorias = $consulta->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div class="form-group">
                    <label for="categoria_producto"> Categoria:
                        <select name="categoria" id="categoria_producto" required>
                            <option value="">Seleccionar Categoria</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id_categoria']; ?>">
                                    <?php echo $categoria['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label for="imagen_producto"> Imagen:
                        <input type="file" class="modificar" name="imagen" id="imagen_producto">
                    </label>
                </div>
            </div>
            <button type="submit" class="btn-save-producto">Crear Producto</button>
        </form>
    </div>
</div>