<?php
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../config/config.php';

$conn = conectar();

// Obtener ID del producto
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// Obtener datos del producto
$stmt = $conn->prepare("SELECT p.*, c.nombre as categoria_nombre 
                         FROM productos p 
                         LEFT JOIN categoria c ON p.id_categoria = c.id_categoria 
                         WHERE p.id_producto = :id AND p.activo = 1");
$stmt->execute([':id' => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    header("Location: index.php");
    exit;
}

// Construir URL absoluta de la imagen para OG
$imagen_ruta = $producto['ruta'];
// Si la ruta es relativa (empieza con ../../), construir la URL absoluta
if (strpos($imagen_ruta, '../../') === 0) {
    $imagen_url = BASE_URL . '/' . ltrim(str_replace('../../', '', $imagen_ruta), '/');
} elseif (strpos($imagen_ruta, '/') === 0) {
    // Ruta absoluta desde la raíz del sitio
    $imagen_url = BASE_URL . $imagen_ruta;
} elseif (strpos($imagen_ruta, 'http') === 0) {
    // Ya es una URL completa
    $imagen_url = $imagen_ruta;
} else {
    $imagen_url = BASE_URL . '/assets/productos/' . $imagen_ruta;
}

$producto_url = BASE_URL . '/public/catalogo/producto.php?id=' . $id;
$nombre = htmlspecialchars($producto['nombre']);
$descripcion = !empty($producto['descripcion']) ? htmlspecialchars($producto['descripcion']) : 'Consultá precio y disponibilidad en Gastón Carpintería y Diseño';
$whatsapp_text = urlencode("Hola, me gustaría solicitar un presupuesto del producto: " . $producto['nombre'] . " - " . $producto['id_producto'] . "\n\nVer producto: " . $producto_url);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?php echo $nombre; ?> | Gastón Carpintería y Diseño</title>

    <!-- Open Graph Meta Tags para WhatsApp Preview -->
    <meta property="og:title" content="<?php echo $nombre; ?>" />
    <meta property="og:description" content="<?php echo $descripcion; ?>" />
    <meta property="og:image" content="<?php echo $imagen_url; ?>" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta property="og:url" content="<?php echo $producto_url; ?>" />
    <meta property="og:type" content="product" />
    <meta property="og:site_name" content="Gastón Carpintería y Diseño" />

    <!-- Twitter Card (también genera previews) -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo $nombre; ?>" />
    <meta name="twitter:description" content="<?php echo $descripcion; ?>" />
    <meta name="twitter:image" content="<?php echo $imagen_url; ?>" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="catalogo.css">
    <link rel="stylesheet" href="../styles.css">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#d4af37",
                        "background-light": "#1c1917",
                        "background-dark": "#151311",
                        "whatsapp": "#25D366",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#fafaf9] dark:text-white antialiased">
    <div class="relative flex min-h-screen w-full flex-col pb-24">

        <!-- Header -->
        <div
            class="sticky top-0 z-50 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-[#44403c] dark:border-[#3d3920]">
            <a href="index.php" class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">
                Detalle del Producto
            </h2>
            <div class="w-10"></div>
        </div>

        <!-- Product Image -->
        <div class="w-full aspect-square max-h-[70vh] overflow-hidden bg-gray-100 dark:bg-[#2a2715]">
            <img src="<?php echo htmlspecialchars($producto['ruta']); ?>" alt="<?php echo $nombre; ?>"
                class="w-full h-full object-contain" />
        </div>

        <!-- Product Info -->
        <div class="px-5 py-6 flex flex-col gap-4" style="margin-top: 2rem; hover:transition(translate-y-2px)">
            <!-- Category & Tags -->
            <div class="flex items-center gap-2 flex-wrap">
                <?php if (!empty($producto['categoria_nombre'])): ?>
                    <span
                        class="text-[10px] font-bold text-white bg-primary px-2.5 py-1 rounded-full uppercase tracking-wider"><?php echo htmlspecialchars($producto['categoria_nombre']); ?></span>
                <?php endif; ?>
                <?php if (!empty($producto['tipo_diseno'])): ?>
                    <span
                        class="text-[10px] font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-full uppercase tracking-wider"><?php echo $producto['tipo_diseno']; ?></span>
                <?php endif; ?>
                <?php if (!empty($producto['superficie_acabado'])): ?>
                    <span
                        class="text-[10px] font-bold text-[#9c8e49] bg-[#9c8e49]/10 px-2.5 py-1 rounded-full uppercase tracking-wider"><?php echo $producto['superficie_acabado']; ?></span>
                <?php endif; ?>
                <?php if (!empty($producto['color_tono'])): ?>
                    <span
                        class="text-[10px] font-bold text-[#666] bg-gray-100 px-2.5 py-1 rounded-full uppercase tracking-wider"><?php echo $producto['color_tono']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Name -->
            <h1 class="text-2xl font-extrabold leading-tight">
                <?php echo $nombre; ?>
            </h1>

            <!-- Description -->
            <?php if (!empty($producto['descripcion'])): ?>
                <p class="text-[#666] dark:text-gray-400 text-sm leading-relaxed">
                    <?php echo htmlspecialchars($producto['descripcion']); ?>
                </p>
            <?php endif; ?>

            <!-- WhatsApp CTA -->
            <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>?text=<?php echo $whatsapp_text; ?>" target="_blank"
                class="mt-4 flex h-14 items-center justify-center gap-3 rounded-2xl bg-whatsapp text-white text-base font-bold shadow-lg shadow-whatsapp/30 transition-all hover:shadow-xl active:scale-[0.98]">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="#ffffff"
                        d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.23 8.23 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.2 8.2 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18s.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01" />
                </svg>
                Consultar Presupuesto por WhatsApp
            </a>

            <!-- Back to catalog -->
            <a href="index.php"
                class="flex h-12 items-center justify-center gap-2 rounded-xl border-2 border-[#44403c] dark:border-[#3d3920] text-sm font-bold transition-all hover:bg-[#292524] dark:hover:bg-[#322e1a]">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Volver al Catálogo
            </a>
        </div>

        <!--        Bottom Navigation Spacer -->
        <div style="height: 6rem;"></div>

        <!--    Sticky Footer / Bottom Nav -->
        <nav>
            <div class="bottom-nav">
                <a href="../index.php" class="nav-item">
                    <span class="app-icon" style="font-variation-settings: 'FILL' 1;">home</span>
                    <span class="nav-label">Inicio</span>
                </a>
                <a href="index.php" class="nav-item active">
                    <span class="app-icon">grid_view</span>
                    <span class="nav-label">Catálogo</span>
                </a>
                <a href="../multimedia/index.php" class="nav-item">
                    <span class="app-icon">image</span>
                    <span class="nav-label">Multimedia</span>
                </a>
                <a href="../contactos/index.php" class="nav-item">
                    <span class="app-icon">contacts</span>
                    <span class="nav-label">Contactos</span>
                </a>
            </div>
        </nav>
    </div>
</body>

</html>