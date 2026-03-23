<?php
require_once __DIR__ . '/../../../config/conexion.php';
$conn = conectar();

$search = isset($_GET['term']) ? trim($_GET['term']) : '';
$where_clause = "";
$params = [];

if (!empty($search)) {
    $where_clause .= " AND (nombre LIKE :search_name OR descripcion LIKE :search_desc)";
    $params[':search_name'] = '%' . $search . '%';
    $params[':search_desc'] = '%' . $search . '%';
}

$sql = "SELECT * FROM productos WHERE activo = 1" . $where_clause . " ORDER BY id_producto DESC LIMIT 30";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($productos) > 0) {
    foreach ($productos as $producto) {
        $rutaImagen = !empty($producto['ruta']) ? $producto['ruta'] : 'https://images.unsplash.com/photo-1586023494664-14d444356981?q=80&w=800&auto=format&fit=crop';
        ?>
        <div class="flex flex-col gap-2 pb-4 bg-white dark:bg-[#2a2715] rounded-xl overflow-hidden shadow-sm border border-[#e8e4d8] dark:border-[#3d3920] group transition-all hover:shadow-md">
            <div class="relative w-full aspect-square bg-center bg-no-repeat bg-cover cursor-zoom-in overflow-hidden"
                style="background-image: url('<?php echo htmlspecialchars($rutaImagen); ?>');"
                onclick="openZoom('<?php echo htmlspecialchars($rutaImagen); ?>', '<?php echo htmlspecialchars($producto['nombre']); ?>')">

                <?php if ($producto['destacado'] == 1): ?>
                    <span class="absolute top-2 left-2 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Más Vendido</span>
                <?php endif; ?>

                <!-- Color Indicator Swatch -->
                <?php if (!empty($producto['color_tono'])):
                    $colorMap = [
                        "Blanco" => "#FFFFFF", "Gris" => "#808080", "Negro" => "#000000",
                        "Madera Clara" => "#D2B48C", "Madera Media" => "#8B4513",
                        "Madera Oscura" => "#3d1c02", "Cálido" => "#f4a460", "Frío" => "#add8e6"
                    ];
                    $hex = isset($colorMap[$producto['color_tono']]) ? $colorMap[$producto['color_tono']] : '#eee';
                    ?>
                    <div class="absolute bottom-2 right-2 w-6 h-6 rounded-full border-2 border-white shadow-sm"
                        style="background-color: <?php echo $hex; ?>" title="<?php echo $producto['color_tono']; ?>">
                    </div>
                <?php endif; ?>

                <!-- Zoom Overlay Icon -->
                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                    <i data-lucide="zoom-in" class="w-8 h-8 text-white drop-shadow-md"></i>
                </div>
            </div>

            <div class="px-3 py-1 flex flex-col flex-1">
                <div class="flex items-center gap-1.5 mb-1">
                    <?php if (!empty($producto['tipo_diseno'])): ?>
                        <span class="text-[9px] font-bold text-primary bg-primary/10 px-1.5 py-0.5 rounded uppercase"><?php echo $producto['tipo_diseno']; ?></span>
                    <?php endif; ?>
                    <?php if (!empty($producto['superficie_acabado'])): ?>
                        <span class="text-[9px] font-bold text-[#9c8e49] bg-[#9c8e49]/10 px-1.5 py-0.5 rounded uppercase"><?php echo $producto['superficie_acabado']; ?></span>
                    <?php endif; ?>
                </div>
                <a class="mt-auto block w-full"
                    href="https://wa.me/5491170580790?text=Hola, me gustaría solicitar un presupuesto del producto: <?php echo htmlspecialchars($producto['nombre']) . ' - ' . htmlspecialchars($producto['id_producto']); ?>"
                    target="_blank">
                    <button class="btn-add-cart-sm w-full flex h-9 items-center justify-center gap-2 rounded-lg bg-primary text-white text-xs font-bold transition-all hover:bg-primary/90">
                        <span class="material-symbols-outlined text-sm">add_shopping_cart</span> Consultar Presupuesto
                    </button>
                </a>
            </div>
        </div>
        <?php
    }
} else {
    echo "<div class='col-span-2 text-center py-10 text-[#9c8e49]'>No se encontraron productos</div>";
}
?>