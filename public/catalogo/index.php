<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Catálogo de Productos - Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="catalogo.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "rgb(124, 61, 50)",
                        "background-light": "#f8f8f5",
                        "background-dark": "#221f10",
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
            min-height: max(884px, 100dvh);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#1c190d] dark:text-white antialiased">
<?php
require_once __DIR__ . '/../../config/conexion.php';
$conn = conectar();

// Fetch categories for filter bar and JS
$catStmt = $conn->prepare("SELECT * FROM categoria");
$catStmt->execute();
$allCategories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

$currentCategory = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos';
?>
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden pb-24">

        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-50 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-[#e8e4d8] dark:border-[#3d3920]">
            <div class="text-[#1c190d] dark:text-white flex size-12 shrink-0 items-center">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </div>
            <h2
                class="text-[#1c190d] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">
                Catálogo Admin
            </h2>
            <div class="flex w-12 items-center justify-end">
                <button
                    class="relative flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 bg-transparent text-[#1c190d] dark:text-white gap-2 text-base font-bold leading-normal tracking-[0.015em] min-w-0 p-0">
                    <span id="carrito_boton" class="material-symbols-outlined text-2xl">shopping_cart</span>
                </button>
            </div>
        </div>

        <!-- Search Bar and Filter Toggle -->
        <div class="px-4 py-3 flex gap-2">
            <form action="index.php" method="get" class="flex-1">
                <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($currentCategory); ?>">
                <div class="relative flex items-center h-12 w-full rounded-xl shadow-sm border border-[#e8e4d8] dark:border-[#3d3920] bg-white dark:bg-[#322e1a] overflow-hidden">
                    <div class="pl-4 text-[#9c8e49]">
                        <button type="submit">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <input
                        class="flex-1 bg-transparent border-none focus:ring-0 text-[#1c190d] dark:text-white px-3 text-base placeholder:text-[#9c8e49]"
                        name="search_input" placeholder="Buscar revestimientos..." 
                        value="<?php echo htmlspecialchars(isset($_GET['search_input']) ? $_GET['search_input'] : ''); ?>" />
                </div>
            </form>
            <button id="open-filters" class="flex items-center justify-center w-12 h-12 rounded-xl bg-white dark:bg-[#322e1a] shadow-sm border border-[#e8e4d8] dark:border-[#3d3920] text-primary">
                <i data-lucide="sliders-horizontal" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Filter Drawer Overlay -->
        <div id="filter-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden transition-opacity"></div>
        
        <!-- Filter Drawer -->
        <div id="filter-drawer" class="fixed right-0 top-0 h-full w-[85%] max-w-sm bg-background-light dark:bg-background-dark z-[101] translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">
            <div class="p-4 border-b border-[#e8e4d8] dark:border-[#3d3920] flex justify-between items-center">
                <h3 class="text-lg font-bold">Filtros</h3>
                <button id="close-filters" class="p-2 text-[#9c8e49]">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <form action="index.php" method="get" class="flex-1 flex flex-col overflow-hidden">
                <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-6">
                    <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($currentCategory); ?>">
                    <input type="hidden" name="search_input" value="<?php echo htmlspecialchars(isset($_GET['search_input']) ? $_GET['search_input'] : ''); ?>">

                    <!-- Color Filter -->
                    <div>
                        <h4 class="text-sm font-bold text-[#9c8e49] uppercase tracking-wider mb-3">Tono de Color</h4>
                        <div class="grid grid-cols-1 gap-2">
                            <?php 
                            $colores = [
                            "Blanco" => "#FFFFFF", 
                            "Gris" => "#808080", 
                            "Negro" => "#000000", 
                            "Madera Clara" => "#D2B48C", 
                            "Madera Media" => "#8B4513", 
                            "Madera Oscura" => "#3d1c02", 
                            "Cálido" => "#f4a460", 
                            "Frío" => "#add8e6"
                        ];
                        foreach($colores as $name => $hex): 
                            $checked = (isset($_GET['color']) && $_GET['color'] == $name) ? 'checked' : '';
                        ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="color" value="<?php echo $name; ?>" class="hidden peer" <?php echo $checked; ?>>
                            <div class="w-5 h-5 rounded-full border border-gray-300 peer-checked:ring-2 peer-checked:ring-primary transition-all" style="background-color: <?php echo $hex; ?>"></div>
                            <span class="text-sm peer-checked:font-bold group-hover:text-primary transition-colors"><?php echo $name; ?></span>
                        </label>
                        <?php endforeach; ?>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="color" value="" class="hidden peer" <?php echo !isset($_GET['color']) || $_GET['color'] == '' ? 'checked' : ''; ?>>
                            <div class="w-5 h-5 rounded-full border border-gray-300 bg-gray-100 peer-checked:ring-2 peer-checked:ring-primary flex items-center justify-center">
                                <i data-lucide="slash" class="w-3 h-3 text-gray-400"></i>
                            </div>
                            <span class="text-sm peer-checked:font-bold">Todos los colores</span>
                        </label>
                    </div>
                </div>

                <!-- Design Type Filter -->
                <div>
                    <h4 class="text-sm font-bold text-[#9c8e49] uppercase tracking-wider mb-3">Tipo de Diseño</h4>
                    <div class="flex flex-col gap-2">
                        <?php 
                        $disenos = ["Unicolor", "Madera", "Material"];
                        foreach($disenos as $d): 
                            $checked = (isset($_GET['diseno']) && $_GET['diseno'] == $d) ? 'checked' : '';
                        ?>
                        <label class="flex items-center justify-between p-3 rounded-xl border border-[#e8e4d8] dark:border-[#3d3920] bg-white dark:bg-[#322e1a] cursor-pointer hover:border-primary transition-colors">
                            <span class="text-sm font-medium"><?php echo $d; ?></span>
                            <input type="radio" name="diseno" value="<?php echo $d; ?>" class="text-primary focus:ring-primary" <?php echo $checked; ?>>
                        </label>
                        <?php endforeach; ?>
                        <label class="flex items-center justify-between p-3 rounded-xl border border-[#e8e4d8] dark:border-[#3d3920] bg-white dark:bg-[#322e1a] cursor-pointer hover:border-primary transition-colors">
                            <span class="text-sm font-medium">Todos los diseños</span>
                            <input type="radio" name="diseno" value="" class="text-primary focus:ring-primary" <?php echo !isset($_GET['diseno']) || $_GET['diseno'] == '' ? 'checked' : ''; ?>>
                        </label>
                    </div>
                </div>

                <!-- Surface Filter -->
                <div>
                    <h4 class="text-sm font-bold text-[#9c8e49] uppercase tracking-wider mb-3">Superficie</h4>
                    <select name="superficie" class="w-full rounded-xl border-[#e8e4d8] dark:border-[#3d3920] bg-white dark:bg-[#322e1a] text-sm py-3 focus:ring-primary focus:border-primary">
                        <option value="">Cualquier superficie</option>
                        <?php 
                        $superficies = ["Mate", "Brillante", "Texturado", "Poroso"];
                        foreach($superficies as $s): 
                            $selected = (isset($_GET['superficie']) && $_GET['superficie'] == $s) ? 'selected' : '';
                            echo "<option value='$s' $selected>$s</option>";
                        endforeach; 
                        ?>
                    </select>
                    </div>
                </div>

                <div class="p-4 border-t border-[#e8e4d8] dark:border-[#3d3920] flex gap-3 bg-background-light dark:bg-background-dark">
                    <a href="index.php?categoria=<?php echo urlencode($currentCategory); ?>" class="flex-1 h-12 flex items-center justify-center rounded-xl border border-[#e8e4d8] dark:border-[#3d3920] text-sm font-bold">Limpiar</a>
                    <button type="submit" class="flex-[2] h-12 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20">Aplicar Filtros</button>
                </div>
            </form>
        </div>

        <script>
            const openBtn = document.getElementById('open-filters');
            const closeBtn = document.getElementById('close-filters');
            const drawer = document.getElementById('filter-drawer');
            const overlay = document.getElementById('filter-overlay');

            const toggleDrawer = (open) => {
                if (open) {
                    overlay.classList.remove('hidden');
                    setTimeout(() => {
                        overlay.style.opacity = '1';
                        drawer.style.transform = 'translateX(0)';
                    }, 10);
                } else {
                    drawer.style.transform = 'translateX(100%)';
                    overlay.style.opacity = '0';
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                    }, 300);
                }
            };

            openBtn.onclick = () => toggleDrawer(true);
            closeBtn.onclick = () => toggleDrawer(false);
            overlay.onclick = () => toggleDrawer(false);
        </script>

        <!-- Category Filters -->
        <div class="flex gap-3 p-4 overflow-x-auto hide-scrollbar whitespace-nowrap">
            <?php
            // Categories already fetched above
            $isActiveTodos = ($currentCategory === 'Todos');
            $bgClassTodos = $isActiveTodos ? 'bg-primary' : 'bg-white dark:bg-[#322e1a] border border-[#e8e4d8] dark:border-none';
            $textClassTodos = $isActiveTodos ? 'text-white font-bold' : 'text-[#1c190d] dark:text-white font-medium';
            ?>
            <a href="index.php"
                class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-xl px-4 shadow-sm <?php echo $bgClassTodos; ?>"
                style="text-decoration: none;">
                <p class="text-sm leading-normal <?php echo $textClassTodos; ?>">Todos</p>
            </a>

            <?php foreach ($allCategories as $row):
                $cat = $row['nombre'];
                $isActive = ($currentCategory === $cat);
                $bgClass = $isActive ? 'bg-primary' : 'bg-white dark:bg-[#322e1a] border border-[#e8e4d8] dark:border-none';
                $textClass = $isActive ? 'text-white font-bold' : 'text-[#1c190d] dark:text-white font-medium';
                // Preserve search/filters when changing category? Egger usually resets filters when changing major category, but let's keep them if they exist
                $url_params = $_GET;
                $url_params['categoria'] = $cat;
                $url = 'index.php?' . http_build_query($url_params);

                // Prettify label
                $label = ucfirst(str_replace('_', ' ', $cat));
                ?>
                <a href="<?php echo $url; ?>"
                    class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-xl px-4 shadow-sm <?php echo $bgClass; ?>"
                    style="text-decoration: none;">
                    <p class="text-sm leading-normal <?php echo $textClass; ?>"><?php echo htmlspecialchars($label); ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="flex items-center justify-between px-4 mt-2">
            <h3 class="text-[#1c190d] dark:text-white text-lg font-extrabold"><?php echo $currentCategory == 'Todos' ? 'Nuestros Productos' : htmlspecialchars(ucfirst(str_replace('_', ' ', $currentCategory))); ?></h3>
            <span class="text-xs font-semibold text-[#9c8e49] uppercase tracking-wider">Muebles Gastón</span>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 p-4">
            <?php
            // 1. Capture inputs
            $search = isset($_GET['search_input']) ? trim($_GET['search_input']) : '';
            $category = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos';
            $color = isset($_GET['color']) ? $_GET['color'] : '';
            $diseno = isset($_GET['diseno']) ? $_GET['diseno'] : '';
            $superficie = isset($_GET['superficie']) ? $_GET['superficie'] : '';

            // 2. Build Query
            $sql = "SELECT p.* FROM productos p LEFT JOIN categoria c ON p.id_categoria  = c.id_categoria WHERE p.activo=1";
            $params = [];

            if (!empty($search)) {
                $sql .= " AND p.nombre LIKE :search";
                $params[':search'] = "%$search%";
            }
            
            if ($category !== 'Todos' && !empty($category)) {
                $sql .= " AND c.nombre = :categoria";
                $params[':categoria'] = $category;
            }

            if (!empty($color)) {
                $sql .= " AND p.color_tono = :color";
                $params[':color'] = $color;
            }
            if (!empty($diseno)) {
                $sql .= " AND p.tipo_diseno = :diseno";
                $params[':diseno'] = $diseno;
            }
            if (!empty($superficie)) {
                $sql .= " AND p.superficie_acabado = :superficie";
                $params[':superficie'] = $superficie;
            }

            // 3. Prepare and Execute
            $preparar = $conn->prepare($sql);
            $preparar->execute($params);
            $productos = $preparar->fetchAll(PDO::FETCH_ASSOC);

            if ($preparar->rowCount() > 0) {
                foreach ($productos as $producto) {
                    ?>
                    <div
                        class="flex flex-col gap-2 pb-4 bg-white dark:bg-[#2a2715] rounded-xl overflow-hidden shadow-sm border border-[#e8e4d8] dark:border-[#3d3920] group transition-all hover:shadow-md">
                        <div class="relative w-full aspect-square bg-center bg-no-repeat bg-cover cursor-zoom-in overflow-hidden"
                            style="background-image: url('<?php echo htmlspecialchars($producto['ruta']); ?>');"
                            onclick="openZoom('<?php echo htmlspecialchars($producto['ruta']); ?>', '<?php echo htmlspecialchars($producto['nombre']); ?>')">

                            <?php if ($producto['destacado'] == 1): ?>
                                <span
                                    class="absolute top-2 left-2 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Más
                                    Vendido</span>
                            <?php endif; ?>

                            <!-- Color Indicator Swatch -->
                            <?php if (!empty($producto['color_tono'])): 
                                // Map color name to hex (same list as filters)
                                $colorMap = [
                                    "Blanco" => "#FFFFFF", "Gris" => "#808080", "Negro" => "#000000", 
                                    "Madera Clara" => "#D2B48C", "Madera Media" => "#8B4513", 
                                    "Madera Oscura" => "#3d1c02", "Cálido" => "#f4a460", "Frío" => "#add8e6"
                                ];
                                $hex = isset($colorMap[$producto['color_tono']]) ? $colorMap[$producto['color_tono']] : '#eee';
                            ?>
                                <div class="absolute bottom-2 right-2 w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background-color: <?php echo $hex; ?>" title="<?php echo $producto['color_tono']; ?>"></div>
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
                            <p class="text-[#1c190d] dark:text-white text-sm font-bold leading-tight line-clamp-2">
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                            </p>
                            <p class="text-[#9c8e49] text-[11px] font-semibold mt-1 line-clamp-1">
                                <?php echo htmlspecialchars($producto['descripcion']); ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='col-span-2 text-center py-10 text-[#9c8e49]'>No se encontraron productos</div>";
            }

            ?>
        </div>

        <!-- FAB (Alternate access) -->
        <div class="fixed bottom-24 right-5 z-50">
            <button title="Presioná para generar el QR " id="qr-btn"
                class="flex items-center justify-center rounded-full h-14 w-14 bg-primary text-white shadow-lg hover:shadow-xl transition-shadow border-4 border-white dark:border-background-dark">
                <span class="material-symbols-outlined text-2xl font-bold">qr_code_2</span>
            </button>
        </div>

        <div id="qr-modal" class="modal" style="display:none">
            <div class="flex flex-col items-center gap-4">
                <h3 class="text-lg font-bold" style="background-color:#fff; padding: 10px; border-radius: 10px;">Escaneá
                    el
                    código QR para ver el catálogo
                </h3>
                <div class="qrcode">
                    <img src="../../assets/qr/qr-code.png" alt="QR">
                </div>
                <button id="close-qr-modal" class="close-btn bg-red-500 text-white px-4 py-2 rounded-lg">Cerrar</button>
            </div>
        </div>

        <script>
            const qrModal = document.getElementById('qr-modal');
            const qrButton = document.getElementById('qr-btn');
            const cerrar = document.getElementById('close-qr-modal');
            qrButton.addEventListener('click', () => {
                qrModal.style.display = 'flex';
            });
            cerrar.addEventListener('click', () => {
                qrModal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === qrModal) {
                    qrModal.style.display = 'none';
                }
            });
        </script>

        <!-- Zoom Modal -->
        <div id="zoom-modal" class="fixed inset-0 z-[200] hidden flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/90 backdrop-blur-md" onclick="closeZoom()"></div>
            <div class="relative max-w-4xl w-full max-h-full flex flex-col items-center">
                <button onclick="closeZoom()" class="absolute -top-12 right-0 text-white p-2">
                    <i data-lucide="x" class="w-8 h-8"></i>
                </button>
                <img id="zoom-img" src="" alt="Zoom" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
                <h3 id="zoom-title" class="text-white text-center mt-4 text-xl font-bold"></h3>
            </div>
        </div>

        <script>
            function openZoom(src, title) {
                const modal = document.getElementById('zoom-modal');
                const img = document.getElementById('zoom-img');
                const titleEl = document.getElementById('zoom-title');
                
                img.src = src;
                titleEl.textContent = title;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeZoom() {
                const modal = document.getElementById('zoom-modal');
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        </script>

        <!-- Bottom Navigation Spacer -->
        <div style="height: 6rem;"></div>
        <!-- Sticky Footer / Bottom Nav -->
        <div class="bottom-nav">
            <a href="index.php">
                <i data-lucide="house" class="w-6 h-6"></i>
                <span class="nav-label">Inicio</span>
            </a>
            <a href="index.php" class="nav-item active">
                <i data-lucide="layout-grid" class="w-6 h-6"></i>
                <span class="nav-label">Catálogo</span>
            </a>
            <a href="../index.php" class="nav-item">
                <i data-lucide="user" class="w-6 h-6"></i>
                <span class="nav-label">Iniciar Sesión</span>
            </a>
        </div>
    </div>


    <!-- Modal Container -->
    <div id="modal_editar" class="modal-editar">
        <div class="modal-content">
            <!-- Content will be injected by JS -->
        </div>
    </div>

    <!-- Pass categories to JS -->
    <script>
        const categoriesData = <?php echo json_encode($allCategories); ?>;
    </script>



    <!-- Scripts -->
    <!-- <script src="modal_editar.js"></script>
    <script src="activar_registrar.js"></script>
    <script src="activar_categoria.js"></script>
    <script src="soft_delete.js"></script> -->
    <script>
        lucide.createIcons();
    </script>
</body>

</html>