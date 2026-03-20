<div id="modal-crear" class="modal-editar">
    <div class="modal-content">
        <h3 class="modal-title"> Subir Archivo Multimedia</h3>
        <form action="backend/crear_multimedia.php" method="post" id="crear-multimedia-modal" enctype="multipart/form-data">

            <span class="cerrar">&times;</span>

            <div class="form-wrapper">

                <div class="form-group">
                    <label for="nombre_multimedia"> Nombre / Título:
                        <input type="text" class="modificar" name="nombre" id="nombre_multimedia" required>
                    </label>
                </div>
                <div class="form-group">
                    <label for="duracion_multimedia"> Duración (seg):
                        <input type="number" class="modificar" name="duracion" id="duracion_multimedia" placeholder="Dejar en blanco si es una imagen">
                    </label>
                </div>

                <?php
                // El archivo ya fue incluido en index.php, pero por seguridad y modularidad:
                require_once __DIR__ . '/../../../config/conexion.php';
                if (!function_exists('conectar')) {
                   // Fallback si por alguna razón no se incluyó
                   die("Error: No se pudo cargar la función de conexión.");
                }
                $conn = conectar();
                $consulta = $conn->prepare("SELECT * FROM formatos");
                $consulta->execute();
                $formatos = $consulta->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div class="form-group">
                    <label for="formato_multimedia"> Formato:
                        <select name="id_formato" id="formato_multimedia" required>
                            <option value="">Seleccionar Formato</option>
                            <?php foreach ($formatos as $formato): ?>
                                <option value="<?php echo $formato['id_formato']; ?>">
                                    <?php echo htmlspecialchars($formato['Nombre']); ?> <!-- uppercase 'N' based on table describe -->
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label for="archivo_multimedia"> Archivo:
                        <input type="file" class="modificar" name="ruta" id="archivo_multimedia" accept="image/*,video/*" required>
                    </label>
                </div>
            </div>
            <button type="submit" class="btn-save-producto">Subir Archivo</button>
        </form>
    </div>
</div>