<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = conectar();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== '1') {
    header("Location: ../../index.php");
    exit;
}



// Obtener datos multimedia con filtro
$tipo = isset($_GET['tipo']) ? trim(strtolower($_GET['tipo'])) : '';
$sql = "SELECT m.*, f.Nombre as formato_nombre, f.tipo 
        FROM multimedia m 
        LEFT JOIN formatos f ON m.id_formato = f.id_formato 
        WHERE m.activo = 1";

$params = [];
if ($tipo === 'video') {
    $sql .= " AND f.tipo = 'video'";
} elseif ($tipo === 'foto') {
    $sql .= " AND f.tipo != 'video'";
}

$sql .= " ORDER BY m.fecha_subida DESC";

$consulta = $conn->prepare($sql);
$consulta->execute($params);
$archivos = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Obtener formatos para pasarlos al JS
$consultaFormatos = $conn->prepare("SELECT id_formato, Nombre FROM formatos");
$consultaFormatos->execute();
$formatosData = $consultaFormatos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Production Index | Multimedia Gallery</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../styles.css">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-container": "#1e293b",
                        "primary-container": "#f2cc0d",
                        "outline-variant": "#cbd5e1",
                        "outline": "#44403c",
                        "surface": "#292524",
                        "on-primary-container": "#685700",
                        "tertiary-fixed-dim": "#50d6f6",
                        "inverse-surface": "#1e293b",
                        "on-tertiary-fixed": "#001f26",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#544606",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#475569",
                        "primary-fixed": "#ffe16e",
                        "surface-container-highest": "#eae2d0",
                        "primary": "#d4af37",
                        "on-surface": "#fafaf9",
                        "inverse-primary": "#e9c400",
                        "surface-dim": "#e1d9c8",
                        "surface-container-lowest": "#0a0a0a",
                        "on-secondary-container": "#f2cc0d",
                        "background": "#1c1917",
                        "tertiary": "#00687b",
                        "secondary-fixed-dim": "#dac67c",
                        "secondary-fixed": "#f8e295",
                        "on-primary": "#0f172a",
                        "on-tertiary-fixed-variant": "#004e5d",
                        "on-error": "#ffffff",
                        "secondary": "#292524",
                        "surface-container-high": "#f0e7d6",
                        "inverse-on-surface": "#f8f0de",
                        "surface-container-low": "#151311",
                        "primary-fixed-dim": "#e9c400",
                        "on-primary-fixed-variant": "#544600",
                        "on-error-container": "#93000a",
                        "surface-variant": "#eae2d0",
                        "surface-bright": "#292524",
                        "error-container": "#ffdad6",
                        "on-secondary": "#fafaf9",
                        "on-tertiary-container": "#006172",
                        "surface-container": "#f5eddb",
                        "tertiary-container": "#5bdfff",
                        "on-secondary-fixed": "#221b00",
                        "on-primary-fixed": "#221b00",
                        "tertiary-fixed": "#adecff",
                        "on-background": "#fafaf9",
                        "surface-tint": "#705d00"
                    },
                    fontFamily: {
                        "headline": ["Work Sans"],
                        "body": ["Work Sans"],
                        "label": ["Work Sans"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Work Sans', sans-serif;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }

        .modal-editar {
            display: none;
            /* hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-editar.is-active {
            display: block;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            position: relative;
        }

        .cerrar {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .cerrar:hover,
        .cerrar:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-save-producto {
            background-color: #f2cc0d;
            color: #0f172a;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        .btn-save-producto:hover {
            background-color: #e9c400;
        }

        .img-preview-container img,
        .img-preview-container video {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
    <script>
        const formatosData = <?php echo json_encode($formatosData); ?>;
    </script>
</head>

<body class="bg-background text-on-background min-h-screen pb-24">
    <!-- TopAppBar -->
    <header
        class="fixed top-0 w-full z-50 bg-[#292524]/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm dark:shadow-none flex items-center justify-between px-5 h-16 w-full">
        <div
            class="sticky top-0 z-50 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-[#44403c] dark:border-[#3d3920]">
            <div class="text-[#fafaf9] dark:text-white flex size-12 shrink-0 items-center">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </div>
            <div
                class="text-[#fafaf9] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">
                Multimedia
            </div>

        </div>
        <button
            class="btn-abrir-modal-registro material-symbols-outlined text-amber-400 dark:text-amber-400 hover:opacity-80 transition-opacity active:scale-95 duration-200"
            data-icon="upload">upload</button>
    </header>
    <main class="pt-20 px-4 max-w-7xl mx-auto">
        <!-- Search and Filter Section -->
        <section class="mt-4 mb-8">
            <div class="relative group">
                <span
                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input
                    class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 shadow-sm focus:ring-2 focus:ring-primary text-on-surface font-medium placeholder:text-on-surface-variant/50"
                    placeholder="Search workshop projects..." type="text" />
            </div>
            <div class="flex gap-2 mt-4 overflow-x-auto pb-2 scrollbar-hide">
                <a href="index.php"
                    class="<?php echo empty($tipo) ? 'bg-secondary text-primary' : 'bg-surface-container-low text-on-surface-variant outline outline-1 outline-outline'; ?> px-4 py-2 rounded-lg text-xs font-bold tracking-widest uppercase flex items-center gap-2 whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm" data-icon="all_inclusive">all_inclusive</span> ALL
                    ASSETS
                </a>
                <a href="index.php?tipo=video"
                    class="<?php echo $tipo === 'video' ? 'bg-secondary text-primary' : 'bg-surface-container-low text-on-surface-variant outline outline-1 outline-outline'; ?> px-4 py-2 rounded-lg text-xs font-bold tracking-widest uppercase flex items-center gap-2 whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm" data-icon="video_library">video_library</span>
                    VIDEOS
                </a>
                <a href="index.php?tipo=foto"
                    class="<?php echo $tipo === 'foto' ? 'bg-secondary text-primary' : 'bg-surface-container-low text-on-surface-variant outline outline-1 outline-outline'; ?> px-4 py-2 rounded-lg text-xs font-bold tracking-widest uppercase flex items-center gap-2 whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm" data-icon="photo_library">photo_library</span>
                    PHOTOS
                </a>
            </div>
        </section>











        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (count($archivos) > 0): ?>
                <?php foreach ($archivos as $archivo): ?>
                    <?php
                    $esVideo = (strtolower($archivo['tipo']) === 'video');
                    $rutaArchivo = htmlspecialchars($archivo['ruta']);
                    $nombreCorto = htmlspecialchars($archivo['nombre']);
                    // Si la ruta no empieza con http o /, asumimos la ruta local
                    if (!preg_match('~^(?:f|ht)tps?://|/~i', $rutaArchivo)) {
                        // En la BD está como ../../assets/multimedia/archivo.jpg
                        $rutaArchivo = htmlspecialchars($archivo['ruta']);
                    }
                    ?>
                    <div class="group bg-secondary rounded-xl overflow-hidden shadow-sm flex flex-col h-full border-none">
                        <div class="relative aspect-video overflow-hidden bg-black/10 flex justify-center items-center">
                            <?php if ($esVideo): ?>
                                <video class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    src="<?php echo $rutaArchivo; ?>" controls preload="metadata"></video>
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <span
                                        class="bg-primary text-on-primary px-2 py-1 rounded text-[10px] font-black tracking-widest uppercase flex items-center gap-1 shadow-sm">
                                        <span class="material-symbols-outlined text-[12px]" data-icon="play_circle"
                                            data-weight="fill" style="font-variation-settings: 'FILL' 1;">play_circle</span> VIDEO
                                    </span>
                                </div>
                                <?php if (!empty($archivo['duracion'])): ?>
                                    <div
                                        class="absolute bottom-3 right-3 text-white bg-black/50 px-2 py-1 rounded text-[10px] font-bold">
                                        <?php echo gmdate("i:s", $archivo['duracion']); ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    src="<?php echo $rutaArchivo; ?>" alt="<?php echo $nombreCorto; ?>" loading="lazy" />
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <span
                                        class="bg-[#292524] text-secondary px-2 py-1 rounded text-[10px] font-black tracking-widest uppercase flex items-center gap-1 shadow-sm">
                                        <span class="material-symbols-outlined text-[12px]" data-icon="image">image</span> FOTO
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
                                <div class="flex gap-2">
                                    <button
                                        class="btn-modificar material-symbols-outlined text-amber-400 hover:text-white transition-colors"
                                        data-id="<?php echo $archivo['id_multimedia']; ?>" data-icon="edit">edit</button>
                                    <button
                                        class="btn-borrar material-symbols-outlined text-red-500 hover:text-red-400 transition-colors"
                                        data-id="<?php echo $archivo['id_multimedia']; ?>" data-icon="delete">delete</button>
                                </div>
                            </div>
                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-slate-800">
                                <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase">
                                    <?php echo date('M d, Y', strtotime($archivo['fecha_subida'])); ?>
                                </span>
                                <a href="<?php echo $rutaArchivo; ?>" target="_blank"
                                    class="text-primary text-[10px] font-black tracking-widest uppercase flex items-center gap-1 hover:underline">
                                    VER <span class="material-symbols-outlined text-sm"
                                        data-icon="open_in_new">open_in_new</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-12 text-center text-slate-400">
                    <span class="material-symbols-outlined text-4xl mb-2">folder_open</span>
                    <p class="font-medium">No hay archivos multimedia disponibles.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>










    <!-- Floating Action Button -->
    <button
        class="btn-abrir-modal-registro fixed bottom-24 right-6 w-14 h-14 bg-primary text-on-primary rounded-full shadow-lg flex items-center justify-center z-40 active:scale-90 transition-transform">
        <span class="material-symbols-outlined text-3xl font-bold" data-icon="add">add</span>
    </button>







    <!--        Bottom Navigation Spacer -->
    <div style="height: 6rem;"></div>

    <!--    Sticky Footer / Bottom Nav -->
    <div class="bottom-nav">
        <a href="../index.php" class="nav-item">
            <span class="app-icon" style="font-variation-settings: 'FILL' 1;">home</span>
            <span class="nav-label">Inicio</span>
        </a>
        <a href="../catalogo/index.php" class="nav-item">
            <span class="app-icon">grid_view</span>
            <span class="nav-label">Catálogo</span>
        </a>
        <a href="index.php" class="nav-item active">
            <span class="app-icon">image</span>
            <span class="nav-label">Multimedia</span>
        </a>
        <a href="../contactos/index.php" class="nav-item">
            <span class="app-icon">contacts</span>
            <span class="nav-label">Contactos</span>
        </a>
        <button type="button" class="nav-item" id="btn-logout" data-id="<?php echo $_SESSION['usuario']; ?>">
                <span class="app-icon"> door_sliding</span>
                <span class="nav-label">Cerrar Sesión</span>
        </button>
        <!-- <a href="pedidos/index.php" class="nav-item">
            <span class="app-icon">receipt_long</span>
            <span class="nav-label">Pedidos</span>
        </a>
        <form action="clientes/index.php" method="post">
            <input type="hidden" name="usuario" value=" <?php echo $_SESSION['usuario']; ?>">
            <button type="submit" class="nav-item">
                <span class="app-icon">people</span>
                <span class="nav-label">Clientes</span>
            </button>
        </form>
        <form action="perfil/index.php" method="post">
            <input type="hidden" name="usuario" value=" <?php echo $_SESSION['usuario']; ?>">
            <button type="submit" class="nav-item">
                <span class="app-icon">person</span>
                <span class="nav-label">Perfil</span>
            </button>
        </form> -->
    </div>
    </div>

    <!-- Modals -->
    <?php require_once("modales/registrar_multimedia.php"); ?>

    <!-- Modal genérico para edición dinamica de modal_editar.js -->
    <div id="modal_editar" class="modal-editar"></div>

    <script src="scripts/activar_registrar.js?v=<?php echo time(); ?>"></script>
    <script src="scripts/modal_editar.js?v=<?php echo time(); ?>"></script>
    <script src="scripts/soft_delete.js?v=<?php echo time(); ?>"></script>

    <script>
        console.log("[DEBUG-INLINE] Verificando elementos...");
        console.log("[DEBUG-INLINE] Botones registrar:", document.querySelectorAll(".btn-abrir-modal-registro").length);
        console.log("[DEBUG-INLINE] Modal crear:", document.getElementById("modal-crear"));

        // Intento de activación forzada para prueba
        window.abrirModalPrueba = function () {
            const m = document.getElementById("modal-crear");
            if (m) {
                m.style.display = "block";
                m.classList.add("is-active");
                console.log("[DEBUG-INLINE] Modal forzado a abrir.");
            } else {
                console.error("[DEBUG-INLINE] No se encontró el modal para forzarlo.");
            }
        }
    </script>
    <script src="../../auth/logout.js"></script>


</body>

</html>