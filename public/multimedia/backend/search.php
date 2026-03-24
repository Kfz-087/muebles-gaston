<?php
require_once __DIR__ . '/../../../config/conexion.php';
$conn = conectar();

$search = isset($_GET['term']) ? trim($_GET['term']) : '';
$tipo = isset($_GET['tipo']) ? trim(strtolower($_GET['tipo'])) : '';

$sql = "SELECT m.*, f.Nombre as formato_nombre, f.tipo 
        FROM multimedia m 
        LEFT JOIN formatos f ON m.id_formato = f.id_formato 
        WHERE m.activo = 1";

$params = [];

if (!empty($search)) {
    $sql .= " AND (m.nombre LIKE :search_name)";
    $params[':search_name'] = '%' . $search . '%';
}

if ($tipo === 'video') {
    $sql .= " AND f.tipo = 'video'";
} elseif ($tipo === 'foto') {
    $sql .= " AND f.tipo != 'video'";
}

$sql .= " ORDER BY m.fecha_subida DESC LIMIT 50";

$consulta = $conn->prepare($sql);
$consulta->execute($params);
$archivos = $consulta->fetchAll(PDO::FETCH_ASSOC);

if (count($archivos) > 0) {
    foreach ($archivos as $archivo) {
        $esVideo = (strtolower($archivo['tipo']) === 'video');
        $rutaArchivo = htmlspecialchars($archivo['ruta']);
        $nombreCorto = htmlspecialchars($archivo['nombre']);
        ?>
        <div class="group bg-secondary rounded-xl overflow-hidden shadow-sm flex flex-col h-full border-none">
            <div class="relative aspect-video overflow-hidden bg-black/10 flex justify-center items-center">
                <?php if ($esVideo): ?>
                    <video class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        src="<?php echo $rutaArchivo; ?>" controls preload="metadata"></video>
                    <div class="absolute top-3 left-3 flex gap-2">
                        <span
                            class="bg-primary text-on-primary px-2 py-1 rounded text-[10px] font-black tracking-widest uppercase flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-[12px]"
                                style="font-variation-settings: 'FILL' 1;">play_circle</span> VIDEO
                        </span>
                    </div>
                <?php else: ?>
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        src="<?php echo $rutaArchivo; ?>" alt="<?php echo $nombreCorto; ?>" loading="lazy" />
                    <div class="absolute top-3 left-3 flex gap-2">
                        <span
                            class="bg-[#292524] text-secondary px-2 py-1 rounded text-[10px] font-black tracking-widest uppercase flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-[12px]">image</span> FOTO
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-white font-bold text-lg leading-tight uppercase tracking-tight line-clamp-2"
                        title="<?php echo $nombreCorto; ?>">
                        <?php echo $nombreCorto; ?>
                    </h3>
                </div>
                <div class="mt-auto flex justify-between items-center pt-4 border-t border-slate-800">
                    <a href="<?php echo $rutaArchivo; ?>" target="_blank"
                        class="text-primary text-[10px] font-black tracking-widest uppercase flex items-center gap-1 hover:underline">
                        VER <span class="material-symbols-outlined text-sm">open_in_new</span>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<div class='col-span-full py-12 text-center text-slate-400'>
            <span class='material-symbols-outlined text-4xl mb-2'>folder_open</span>
            <p class='font-medium'>No se encontraron archivos multimedia.</p>
          </div>";
}
?>