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
    <link rel="stylesheet" href="../styles.css">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "rgb(124, 61, 50)",
                        "background-light": "#f8f8f5",
                        "background-dark": "#221f10",
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

        <!-- Search Bar -->
        <div class="px-4 py-3">
            <form action="index.php" method="get" class="w-full flex flex-col gap-3">
                <input type="hidden" name="categoria"
                    value="<?php echo htmlspecialchars(isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos'); ?>">

                <!-- Search row -->
                <label class="flex flex-col min-w-40 h-12 w-full">
                    <div
                        class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-sm border border-[#e8e4d8] dark:border-[#3d3920]">
                        <div
                            class="text-[#9c8e49] flex border-none bg-white dark:bg-[#322e1a] items-center justify-center pl-4 rounded-l-xl border-r-0">
                            <button type="submit" class="flex items-center justify-center">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                        </div>
                        <input
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#1c190d] dark:text-white focus:outline-0 focus:ring-0 border-none bg-white dark:bg-[#322e1a] focus:border-none h-full placeholder:text-[#9c8e49] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                            name="search_input" placeholder="Buscar productos..."
                            value="<?php echo htmlspecialchars(isset($_GET['search_input']) ? $_GET['search_input'] : ''); ?>" />
                        <div class="text-[#9c8e49] flex border-none bg-white dark:bg-[#322e1a] items-center justify-center pr-4 rounded-r-xl cursor-pointer"
                            id="toggle-advanced-filters">
                            <span class="material-symbols-outlined text-xl">tune</span>
                        </div>
                    </div>
                </label>

                <!-- Advanced Filters (Initially Hidden or toggleable) -->
                <div id="advanced-filters"
                    class="<?php echo (isset($_GET['color']) || isset($_GET['diseno']) || isset($_GET['superficie'])) ? '' : 'hidden'; ?> grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <select name="color"
                        class="rounded-xl border-[#e8e4d8] dark:border-[#3d3920] bg-white dark:bg-[#322e1a] text-sm py-2">
                        <option value="">Cualquier Color</option>
                        <?php
                        $colores = ["Blanco", "Gris", "Negro", "Madera Clara", "Madera Media", "Madera Oscura", "Cálido", "Frío"];
                        foreach ($colores as $c) {
                            $sel = (isset($_GET['color']) && $_GET['color'] == $c) ? 'selected' : '';
                            echo "<option value='$c' $sel>$c</option>";
                        }
                        ?>
                    </select>

                    <select name="diseno"
                        class="rounded-xl border-[#e8e4d8] dark:border-[#3d3920] bg-white dark:bg-[#322e1a] text-sm py-2">
                        <option value="">Cualquier Diseño</option>
                        <option value="Unicolor" <?php echo (isset($_GET['diseno']) && $_GET['diseno'] == 'Unicolor') ? 'selected' : ''; ?>>Unicolor</option>
                        <option value="Madera" <?php echo (isset($_GET['diseno']) && $_GET['diseno'] == 'Madera') ? 'selected' : ''; ?>>Madera</option>
                        <option value="Material" <?php echo (isset($_GET['diseno']) && $_GET['diseno'] == 'Material') ? 'selected' : ''; ?>>Material</option>
                    </select>

                    <select name="superficie"
                        class="rounded-xl border-[#e8e4d8] dark:border-[#3d3920] bg-white dark:bg-[#322e1a] text-sm py-2">
                        <option value="">Cualquier Acabado</option>
                        <option value="Mate" <?php echo (isset($_GET['superficie']) && $_GET['superficie'] == 'Mate') ? 'selected' : ''; ?>>Mate</option>
                        <option value="Brillante" <?php echo (isset($_GET['superficie']) && $_GET['superficie'] == 'Brillante') ? 'selected' : ''; ?>>Brillante</option>
                        <option value="Texturado" <?php echo (isset($_GET['superficie']) && $_GET['superficie'] == 'Texturado') ? 'selected' : ''; ?>>Texturado</option>
                        <option value="Poroso" <?php echo (isset($_GET['superficie']) && $_GET['superficie'] == 'Poroso') ? 'selected' : ''; ?>>Poroso</option>
                    </select>
                </div>

                <script>
                    document.getElementById('toggle-advanced-filters').addEventListener('click', function () {
                        const advancedFilters = document.getElementById('advanced-filters');
                        advancedFilters.classList.toggle('hidden');
                    });
                </script>
            </form>
        </div>

        <!-- Create Product Button -->
        <div class="px-4 mb-2">
            <button type="button"
                class="w-full flex h-10 items-center justify-center gap-2 rounded-xl bg-primary text-white text-sm font-bold shadow-sm"
                id="crear_producto">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                Crear Producto
            </button>
        </div>

        <!-- Category Filters -->
        <div class="flex gap-3 p-4 overflow-x-auto scrollbar whitespace-collapse:collapse">
            <?php
            require_once __DIR__ . '/../../config/conexion.php';
            $conn = conectar();

            // Fetch categories for filter bar and JS
            $catStmt = $conn->prepare("SELECT * FROM categoria");
            $catStmt->execute();
            $allCategories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

            $currentCategory = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos';

            // "Todos" option
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
                $url = 'index.php?categoria=' . urlencode($cat);

                // Prettify label
                $label = ucfirst(str_replace('_', ' ', $cat));
                ?>
                <a href="<?php echo $url; ?>"
                    class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-xl px-4 shadow-sm <?php echo $bgClass; ?>"
                    style="text-decoration: none;">
                    <p class="text-sm leading-normal <?php echo $textClass; ?>"><?php echo htmlspecialchars($label); ?></p>
                </a>
            <?php endforeach; ?>

            <button type="button"
                class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-white dark:bg-[#322e1a] px-4 shadow-sm border border-[#e8e4d8] dark:border-none"
                id="btn-categoria">
                <span class="material-symbols-outlined text-lg text-primary">edit</span>
                <p class="text-[#1c190d] dark:text-white text-sm font-medium leading-normal">Crear Categoría</p>
            </button>
        </div>

        <div class="flex items-center justify-between px-4 mt-2">
            <h3 class="text-[#1c190d] dark:text-white text-lg font-extrabold">Populares por Mayor</h3>
            <button class="text-sm font-semibold text-[#9c8e49]">Ver todo</button>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 p-4">
            <?php
            // 1. Capture inputs
            $search = isset($_GET['search_input']) ? trim($_GET['search_input']) : '';
            $category = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos';
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
            $items_per_page = 30; // Fits well with 2, 3, 5, 6 columns
            $offset = ($page - 1) * $items_per_page;

            // 2. Build Base Query for Count and Fetch
            $base_sql = "FROM productos p LEFT JOIN categoria c ON p.id_categoria = c.id_categoria WHERE activo=1";
            $params = [];

            if (!empty($search)) {
                $base_sql .= " AND p.nombre LIKE :search";
                $params[':search'] = "%$search%";
            } elseif ($category !== 'Todos' && !empty($category)) {
                $base_sql .= " AND c.nombre = :categoria";
                $params[':categoria'] = $category;
            }

            // Advanced filters
            $color = isset($_GET['color']) ? $_GET['color'] : '';
            $diseno = isset($_GET['diseno']) ? $_GET['diseno'] : '';
            $superficie = isset($_GET['superficie']) ? $_GET['superficie'] : '';

            if (!empty($color)) {
                $base_sql .= " AND p.color_tono = :color";
                $params[':color'] = $color;
            }
            if (!empty($diseno)) {
                $base_sql .= " AND p.tipo_diseno = :diseno";
                $params[':diseno'] = $diseno;
            }
            if (!empty($superficie)) {
                $base_sql .= " AND p.superficie_acabado = :superficie";
                $params[':superficie'] = $superficie;
            }

            // 2.5 Count total items
            $count_sql = "SELECT COUNT(*) " . $base_sql;
            $count_stmt = $conn->prepare($count_sql);
            $count_stmt->execute($params);
            $total_items = $count_stmt->fetchColumn();
            $total_pages = ceil($total_items / $items_per_page);
            if ($total_pages < 1)
                $total_pages = 1;

            // 3. Prepare and Execute Products
            $sql = "SELECT p.* " . $base_sql . " LIMIT :limit OFFSET :offset";
            $preparar = $conn->prepare($sql);

            // bind parameters
            foreach ($params as $key => $val) {
                $preparar->bindValue($key, $val);
            }
            $preparar->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
            $preparar->bindValue(':offset', $offset, PDO::PARAM_INT);

            $preparar->execute();
            $productos = $preparar->fetchAll(PDO::FETCH_ASSOC);

            if (count($productos) > 0) {
                foreach ($productos as $producto) {
                    ?>
                    <div
                        class="flex flex-col gap-2 pb-4 bg-white dark:bg-[#2a2715] rounded-xl overflow-hidden shadow-sm border border-[#e8e4d8] dark:border-[#3d3920]">
                        <div class="relative w-full aspect-square overflow-hidden">
                            <!-- Background Image Layer -->
                            <div class="absolute inset-0 bg-center bg-no-repeat bg-cover"
                                style="background-image: url('<?php echo htmlspecialchars($producto['ruta']); ?>'); <?php echo ($producto['activo'] != 1) ? 'filter: grayscale(100%); opacity: 0.8;' : ''; ?>">
                            </div>

                            <!-- Badges -->
                            <?php if ($producto['activo'] != 1): ?>
                                <span
                                    class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider z-10">Inactivo</span>
                            <?php elseif ($producto['destacado'] == 1): ?>
                                <span
                                    class="absolute top-2 left-2 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider z-10">Más
                                    Vendido</span>
                            <?php endif; ?>

                            <!-- Action Buttons -->
                            <?php if ($producto['activo'] == 1): ?>
                                <div class="absolute top-2 right-2 flex flex-col gap-2 z-10">
                                    <button
                                        class="btn-modificar bg-white/90 dark:bg-black/70 p-1.5 rounded-full shadow-md border border-primary/50 text-primary hover:scale-110 transition-transform"
                                        data-id="<?php echo $producto['id_producto']; ?>">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button
                                        class="btn-borrar bg-white/90 dark:bg-black/70 p-1.5 rounded-full shadow-md border border-red-500/50 text-red-500 hover:scale-110 transition-transform"
                                        data-id="<?php echo $producto['id_producto']; ?>">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            <?php if ($producto['activo'] == 0): ?>
                                <div class="absolute top-2 right-2 flex flex-col gap-2 z-10">
                                    <button
                                        class="btn-restaurar bg-white/90 dark:bg-black/70 p-1.5 rounded-full shadow-md border border-primary/50 text-primary hover:scale-110 transition-transform"
                                        data-id="<?php echo $producto['id_producto']; ?>">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button
                                        class="btn-definitivo bg-white/90 dark:bg-black/70 p-1.5 rounded-full shadow-md border border-red-500/50 text-red-500 hover:scale-110 transition-transform"
                                        data-id="<?php echo $producto['id_producto']; ?>">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            <?php endif; ?>



                        </div>

                        <div class="px-3 py-1 flex flex-col flex-1">
                            <p
                                class="text-[#1c190d] dark:text-white text-sm font-bold leading-tight line-clamp-2 mb-3 h-10 min-h-[2.5rem]">
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                            </p>
                            <!-- <p class="text-[#9c8e49] text-[11px] font-semibold mt-1 line-clamp-1">
                                <?php echo htmlspecialchars($producto['descripcion']); ?>
                            </p> -->
                            <a class="mt-auto block w-full"
                                href="https://wa.me/5491170580790?text=Hola, me gustaría solicitar un presupuesto del producto: <?php echo htmlspecialchars($producto['nombre']) . ' ' . htmlspecialchars($producto['ruta']); ?>">
                                <button
                                    class="btn-add-cart-sm w-full flex h-9 items-center justify-center gap-2 rounded-lg bg-primary text-white text-xs font-bold transition-all hover:bg-primary/90">
                                    <span class="material-symbols-outlined text-sm">add_shopping_cart</span> Consultar
                                    Presupuesto
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
        </div>

        <!-- Pagination Controls -->
        <?php if ($total_pages > 1): ?>
            <div class="px-4 py-6 flex justify-center items-center gap-2">
                <?php
                // Utility to build query string for pagination links
                function getPageUrl($pageNum)
                {
                    $query = $_GET;
                    $query['page'] = $pageNum;
                    return 'index.php?' . http_build_query($query);
                }
                ?>

                <!-- Previous Button -->
                <?php if ($page > 1): ?>
                    <a href="<?php echo htmlspecialchars(getPageUrl($page - 1)); ?>"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-white dark:bg-[#322e1a] shadow-sm border border-[#e8e4d8] dark:border-[#3d3920] text-[#1c190d] dark:text-white hover:bg-gray-50 dark:hover:bg-[#3a351e] transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>
                <?php endif; ?>

                <!-- Page Numbers -->
                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);

                if ($start > 1) {
                    echo '<a href="' . htmlspecialchars(getPageUrl(1)) . '" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white dark:bg-[#322e1a] shadow-sm border border-[#e8e4d8] dark:border-[#3d3920] text-sm font-bold text-[#1c190d] dark:text-white hover:bg-gray-50 dark:hover:bg-[#3a351e] transition-colors">1</a>';
                    if ($start > 2) {
                        echo '<span class="flex h-10 w-10 items-center justify-center text-[#9c8e49] font-bold">...</span>';
                    }
                }

                for ($i = $start; $i <= $end; $i++) {
                    $isCurrent = ($i == $page);
                    $bgClass = $isCurrent ? 'bg-primary border-primary text-white' : 'bg-white dark:bg-[#322e1a] border-[#e8e4d8] dark:border-[#3d3920] text-[#1c190d] dark:text-white hover:bg-gray-50 dark:hover:bg-[#3a351e]';
                    echo '<a href="' . htmlspecialchars(getPageUrl($i)) . '" class="flex h-10 w-10 items-center justify-center rounded-xl shadow-sm border ' . $bgClass . ' text-sm font-bold transition-colors">' . $i . '</a>';
                }

                if ($end < $total_pages) {
                    if ($end < $total_pages - 1) {
                        echo '<span class="flex h-10 w-10 items-center justify-center text-[#9c8e49] font-bold">...</span>';
                    }
                    echo '<a href="' . htmlspecialchars(getPageUrl($total_pages)) . '" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white dark:bg-[#322e1a] shadow-sm border border-[#e8e4d8] dark:border-[#3d3920] text-sm font-bold text-[#1c190d] dark:text-white hover:bg-gray-50 dark:hover:bg-[#3a351e] transition-colors">' . $total_pages . '</a>';
                }
                ?>

                <!-- Next Button -->
                <?php if ($page < $total_pages): ?>
                    <a href="<?php echo htmlspecialchars(getPageUrl($page + 1)); ?>"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-white dark:bg-[#322e1a] shadow-sm border border-[#e8e4d8] dark:border-[#3d3920] text-[#1c190d] dark:text-white hover:bg-gray-50 dark:hover:bg-[#3a351e] transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- FAB (Alternate access) -->
        <div class="fixed bottom-24 right-5 z-50">
            <button title="Presioná para generar el QR " id="qr-btn"
                class="flex items-center justify-center rounded-full h-14 w-14 bg-primary text-white shadow-lg hover:shadow-xl transition-shadow border-4 border-white dark:border-background-dark">
                <span class="material-symbols-outlined text-2xl font-bold">qr_code_2</span>
            </button>
        </div>

        <!-- FAB (Alternate access) -->
        <div class="fixed bottom-40 right-5 z-50">
            <a href="https://wa.me/5491170580790" target="_blank" title="Chatear por WhatsApp" id="wsp-btn"
                class="flex items-center justify-center rounded-full h-14 w-14 bg-whatsapp text-white shadow-lg hover:shadow-xl transition-shadow border-4 border-white dark:border-background-dark">
                <span class="material-symbols-outlined text-2xl font-bold"> <svg xmlns="http://www.w3.org/2000/svg"
                        width="32" height="32" viewBox="0 0 24 24">
                        <path fill="#ffffff"
                            d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.23 8.23 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.2 8.2 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18s.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01" />
                    </svg> </span>
            </a>
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


        <!--        Bottom Navigation Spacer -->
        <div style="height: 6rem;"></div>

        <!--    Sticky Footer / Bottom Nav -->
        <div class="bottom-nav">
            <a href="../index.php" class="nav-item ">
                <span class="app-icon" style="font-variation-settings: 'FILL' 1;">home</span>
                <span class="nav-label">Inicio</span>
            </a>
            <a href="index.php" class="nav-item active">
                <span class="app-icon">grid_view</span>
                <span class="nav-label">Catálogo</span>
            </a>
            <a href="../taller/index.php" class="nav-item">
                <span class="app-icon">build</span>
                <span class="nav-label">Taller</span>
            </a>
            <a href="../multimedia/index.php" class="nav-item">
                <span class="app-icon">image</span>
                <span class="nav-label">Multimedia</span>
            </a>
            <a href="../contactos/index.php" class="nav-item">
                <span class="app-icon">contacts</span>
                <span class="nav-label">Contactos</span>
            </a>
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

    <!-- Modal Container -->
    <div id="modal_editar" class="modal-editar">
        <div class="modal-content">
            <!-- Content will be injected by JS -->
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Sobre Nosotros</h3>
                <p>Gastón Carpintería y Diseño ofrece muebles de alta calidad con más de 20 años de experiencia.</p>
            </div>
            <div class="footer-section">
                <h3>Contacto</h3>
                <p>Email: [EMAIL_ADDRESS]</p>
                <p>Teléfono: +54 9 11 1234-5678</p>
            </div>
            <div class="footer-section">

                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3> Aceptamos estos medios de pago: </h3>
                <div class="payment-links">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64px" height="64px" viewBox="0 0 24 24">
                            <path fill="#ffffff"
                                d="M20.689 8.87L22 15.129h-1.502c-.06-.262-.107-.536-.167-.798s0-.131-.155-.131h-1.823a.143.143 0 0 0-.167.13c-.084.24-.167.478-.262.704c-.096.226-.084.107-.12.107h-1.608v-.143q1.192-2.825 2.383-5.661a.69.69 0 0 1 .62-.453c.524-.024 1.001-.012 1.49-.012m-1.12 1.753l-.847 2.277h1.335zM6.112 13.126v-.143c.477-1.323.965-2.646 1.43-3.969c0-.107.096-.155.215-.155h1.585v.155l-2.467 5.96a.203.203 0 0 1-.227.154H5.266c-.12 0-.167 0-.203-.155c-.44-1.716-.894-3.432-1.335-5.16a.35.35 0 0 0-.155-.215A7 7 0 0 0 2.12 8.99s-.084-.06-.12-.083a.3.3 0 0 1 .155 0h2.384a.715.715 0 0 1 .822.68l.68 3.491a.3.3 0 0 0 0 .084zm5.554 1.764l.239-1.395l.167.096a3 3 0 0 0 1.978.274a.62.62 0 0 0 .548-.465a.58.58 0 0 0-.357-.596c-.239-.155-.5-.274-.727-.429a4 4 0 0 1-.81-.596a1.645 1.645 0 0 1 0-2.11a2.63 2.63 0 0 1 1.346-.786a4.1 4.1 0 0 1 2.384.119h.06l-.227 1.287a7 7 0 0 0-.918-.214a6 6 0 0 0-.93 0a.6.6 0 0 0-.297.155a.36.36 0 0 0 0 .548q.214.197.464.346c.31.19.632.345.93.548a1.715 1.715 0 0 1 .048 2.896a3.13 3.13 0 0 1-1.645.644a4.6 4.6 0 0 1-2.253-.322m-2.646.238l1.025-6.257h1.633l-1.025 6.257z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="64px" height="64px" viewBox="0 0 256 199">
                            <path
                                d="M46.54 198.011V184.84c0-5.05-3.074-8.342-8.343-8.342c-2.634 0-5.488.878-7.464 3.732c-1.536-2.415-3.731-3.732-7.024-3.732c-2.196 0-4.39.658-6.147 3.073v-2.634h-4.61v21.074h4.61v-11.635c0-3.731 1.976-5.488 5.05-5.488c3.072 0 4.61 1.976 4.61 5.488v11.635h4.61v-11.635c0-3.731 2.194-5.488 5.048-5.488c3.074 0 4.61 1.976 4.61 5.488v11.635zm68.271-21.074h-7.463v-6.366h-4.61v6.366h-4.171v4.17h4.17v9.66c0 4.83 1.976 7.683 7.245 7.683c1.976 0 4.17-.658 5.708-1.536l-1.318-3.952c-1.317.878-2.853 1.098-3.951 1.098c-2.195 0-3.073-1.317-3.073-3.513v-9.44h7.463zm39.076-.44c-2.634 0-4.39 1.318-5.488 3.074v-2.634h-4.61v21.074h4.61v-11.854c0-3.512 1.536-5.488 4.39-5.488c.878 0 1.976.22 2.854.439l1.317-4.39c-.878-.22-2.195-.22-3.073-.22m-59.052 2.196c-2.196-1.537-5.269-2.195-8.562-2.195c-5.268 0-8.78 2.634-8.78 6.805c0 3.513 2.634 5.488 7.244 6.147l2.195.22c2.415.438 3.732 1.097 3.732 2.195c0 1.536-1.756 2.634-4.83 2.634s-5.488-1.098-7.025-2.195l-2.195 3.512c2.415 1.756 5.708 2.634 9 2.634c6.147 0 9.66-2.853 9.66-6.805c0-3.732-2.854-5.708-7.245-6.366l-2.195-.22c-1.976-.22-3.512-.658-3.512-1.975c0-1.537 1.536-2.415 3.951-2.415c2.635 0 5.269 1.097 6.586 1.756zm122.495-2.195c-2.635 0-4.391 1.317-5.489 3.073v-2.634h-4.61v21.074h4.61v-11.854c0-3.512 1.537-5.488 4.39-5.488c.879 0 1.977.22 2.855.439l1.317-4.39c-.878-.22-2.195-.22-3.073-.22m-58.833 10.976c0 6.366 4.39 10.976 11.196 10.976c3.073 0 5.268-.658 7.463-2.414l-2.195-3.732c-1.756 1.317-3.512 1.975-5.488 1.975c-3.732 0-6.366-2.634-6.366-6.805c0-3.951 2.634-6.586 6.366-6.805c1.976 0 3.732.658 5.488 1.976l2.195-3.732c-2.195-1.757-4.39-2.415-7.463-2.415c-6.806 0-11.196 4.61-11.196 10.976m42.588 0v-10.537h-4.61v2.634c-1.537-1.975-3.732-3.073-6.586-3.073c-5.927 0-10.537 4.61-10.537 10.976s4.61 10.976 10.537 10.976c3.073 0 5.269-1.097 6.586-3.073v2.634h4.61zm-16.904 0c0-3.732 2.415-6.805 6.366-6.805c3.732 0 6.367 2.854 6.367 6.805c0 3.732-2.635 6.805-6.367 6.805c-3.951-.22-6.366-3.073-6.366-6.805m-55.1-10.976c-6.147 0-10.538 4.39-10.538 10.976s4.39 10.976 10.757 10.976c3.073 0 6.147-.878 8.562-2.853l-2.196-3.293c-1.756 1.317-3.951 2.195-6.146 2.195c-2.854 0-5.708-1.317-6.367-5.05h15.587v-1.755c.22-6.806-3.732-11.196-9.66-11.196m0 3.951c2.853 0 4.83 1.757 5.268 5.05h-10.976c.439-2.854 2.415-5.05 5.708-5.05m114.372 7.025v-18.879h-4.61v10.976c-1.537-1.975-3.732-3.073-6.586-3.073c-5.927 0-10.537 4.61-10.537 10.976s4.61 10.976 10.537 10.976c3.074 0 5.269-1.097 6.586-3.073v2.634h4.61zm-16.903 0c0-3.732 2.414-6.805 6.366-6.805c3.732 0 6.366 2.854 6.366 6.805c0 3.732-2.634 6.805-6.366 6.805c-3.952-.22-6.366-3.073-6.366-6.805m-154.107 0v-10.537h-4.61v2.634c-1.537-1.975-3.732-3.073-6.586-3.073c-5.927 0-10.537 4.61-10.537 10.976s4.61 10.976 10.537 10.976c3.074 0 5.269-1.097 6.586-3.073v2.634h4.61zm-17.123 0c0-3.732 2.415-6.805 6.366-6.805c3.732 0 6.367 2.854 6.367 6.805c0 3.732-2.635 6.805-6.367 6.805c-3.951-.22-6.366-3.073-6.366-6.805" />
                            <path fill="#FF5F00" d="M93.298 16.903h69.15v124.251h-69.15z" />
                            <path fill="#EB001B"
                                d="M97.689 79.029c0-25.245 11.854-47.637 30.074-62.126C114.373 6.366 97.47 0 79.03 0C35.343 0 0 35.343 0 79.029s35.343 79.029 79.029 79.029c18.44 0 35.343-6.366 48.734-16.904c-18.22-14.269-30.074-36.88-30.074-62.125" />
                            <path fill="#F79E1B"
                                d="M255.746 79.029c0 43.685-35.343 79.029-79.029 79.029c-18.44 0-35.343-6.366-48.734-16.904c18.44-14.488 30.075-36.88 30.075-62.125s-11.855-47.637-30.075-62.126C141.373 6.366 158.277 0 176.717 0c43.686 0 79.03 35.563 79.03 79.029" />
                        </svg>
                        </i></a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24">
                        <path fill="#ffffff"
                            d="M11.115 16.479a.93.927 0 0 1-.939-.886c-.002-.042-.006-.155-.103-.155c-.04 0-.074.023-.113.059c-.112.103-.254.206-.46.206a.816.814 0 0 1-.305-.066c-.535-.214-.542-.578-.521-.725c.006-.038.007-.08-.02-.11l-.032-.03h-.034c-.027 0-.055.012-.093.039a.788.786 0 0 1-.454.16a.7.699 0 0 1-.253-.05c-.708-.27-.65-.928-.617-1.126q.008-.062-.03-.092l-.05-.04l-.047.043a.728.726 0 0 1-.505.203a.73.728 0 0 1-.732-.725c0-.4.328-.722.732-.722c.364 0 .675.27.721.63l.026.195l.11-.165c.01-.018.307-.46.852-.46c.102 0 .21.016.316.05c.434.13.508.52.519.68c.008.094.075.1.09.1c.037 0 .064-.024.083-.045a.746.744 0 0 1 .54-.225q.193 0 .402.09c.69.293.379 1.158.374 1.167c-.058.144-.061.207-.005.244l.027.013h.02c.03 0 .07-.014.134-.035c.093-.032.235-.08.367-.08a.944.942 0 0 1 .94.93a.936.934 0 0 1-.94.928m7.302-4.171c-1.138-.98-3.768-3.24-4.481-3.77c-.406-.302-.685-.462-.928-.533a1.559 1.554 0 0 0-.456-.07q-.274 0-.58.095c-.46.145-.918.505-1.362.854l-.023.018c-.414.324-.84.66-1.164.73a1.986 1.98 0 0 1-.43.049c-.362 0-.687-.104-.81-.258q-.03-.037.04-.125l.008-.008l1-1.067c.783-.774 1.525-1.506 3.23-1.545h.085c1.062 0 2.12.469 2.24.524a7 7 0 0 0 3.056.724c1.076 0 2.188-.263 3.354-.795a9.135 9.11 0 0 0-.405-.317c-1.025.44-2.003.66-2.946.66c-.962 0-1.925-.229-2.858-.68c-.05-.022-1.22-.567-2.44-.57q-.049 0-.096.002c-1.434.033-2.24.536-2.782.976c-.528.013-.982.138-1.388.25c-.361.1-.673.186-.979.185c-.125 0-.35-.01-.37-.012c-.35-.01-2.115-.437-3.518-.962q-.213.15-.415.31c1.466.593 3.25 1.053 3.812 1.089c.157.01.323.027.491.027c.372 0 .744-.103 1.104-.203c.213-.059.446-.123.692-.17l-.196.194l-1.017 1.087c-.08.08-.254.294-.14.557a.705.703 0 0 0 .268.292c.243.162.677.27 1.08.271q.23 0 .43-.044c.427-.095.874-.448 1.349-.82c.377-.296.913-.672 1.323-.782a1.494 1.49 0 0 1 .37-.05a.611.61 0 0 1 .095.005c.27.034.533.125 1.003.472c.835.62 4.531 3.815 4.566 3.846c.002.002.238.203.22.537c-.007.186-.11.352-.294.466a.902.9 0 0 1-.484.15a.804.802 0 0 1-.428-.124c-.014-.01-1.28-1.157-1.746-1.543c-.074-.06-.146-.115-.22-.115a.12.12 0 0 0-.096.045c-.073.09.01.212.105.294l1.48 1.47c.002 0 .184.17.204.395q.017.367-.35.606a.957.955 0 0 1-.526.171a.766.764 0 0 1-.42-.127l-.214-.206a21.035 20.978 0 0 0-1.08-1.009c-.072-.058-.148-.112-.221-.112a.13.13 0 0 0-.094.038c-.033.037-.056.103.028.212a.698.696 0 0 0 .075.083l1.078 1.198c.01.01.222.26.024.511l-.038.048a1.18 1.178 0 0 1-.1.096c-.184.15-.43.164-.527.164a.8.798 0 0 1-.147-.012q-.16-.027-.212-.089l-.013-.013c-.06-.06-.602-.609-1.054-.98c-.059-.05-.133-.11-.21-.11a.13.13 0 0 0-.096.042c-.09.096.044.24.1.293l.92 1.003a.2.2 0 0 1-.033.062c-.033.044-.144.155-.479.196a.91.907 0 0 1-.122.007c-.345 0-.712-.164-.902-.264a1.343 1.34 0 0 0 .13-.576a1.368 1.365 0 0 0-1.42-1.357c.024-.342-.025-.99-.697-1.274a1.455 1.452 0 0 0-.575-.125q-.22 0-.42.075a1.153 1.15 0 0 0-.671-.564a1.52 1.515 0 0 0-.494-.085q-.421 0-.767.242a1.168 1.165 0 0 0-.903-.43a1.173 1.17 0 0 0-.82.335c-.287-.217-1.425-.93-4.467-1.613a17.39 17.344 0 0 1-.692-.189a4.822 4.82 0 0 0-.077.494l.67.157c3.108.682 4.136 1.391 4.309 1.525a1.145 1.142 0 0 0-.09.442a1.16 1.158 0 0 0 1.378 1.132c.096.467.406.821.879 1.003a1.165 1.162 0 0 0 .415.08q.135 0 .266-.034c.086.22.282.493.722.668a1.233 1.23 0 0 0 .457.094q.183 0 .355-.063a1.373 1.37 0 0 0 1.269.841c.37.002.726-.147.985-.41c.221.121.688.341 1.163.341q.09.001.175-.01c.47-.059.689-.24.789-.382a.571.57 0 0 0 .048-.078c.11.032.234.058.373.058c.255 0 .501-.086.75-.265c.244-.174.418-.424.444-.637v-.01q.125.026.251.026c.265 0 .527-.082.773-.242c.48-.31.562-.715.554-.98a1.28 1.279 0 0 0 .978-.194a1.04 1.04 0 0 0 .502-.808a1.088 1.085 0 0 0-.16-.653c.804-.342 2.636-1.003 4.795-1.483a4.734 4.721 0 0 0-.067-.492a27.742 27.667 0 0 0-5.049 1.62zm5.123-.763c0 4.027-5.166 7.293-11.537 7.293S.465 15.572.465 11.545S5.63 4.252 12.004 4.252c6.371 0 11.537 3.265 11.537 7.293zm.46.004c0-4.272-5.374-7.755-12-7.755S.002 7.277.002 11.55L0 12.004c0 4.533 4.695 8.203 11.999 8.203c7.347 0 12-3.67 12-8.204z" />
                    </svg>

                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Gastón Carpintería y Diseño. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Pass categories to JS -->
    <script>
        const categoriesData = <?php echo json_encode($allCategories); ?>;
    </script>

    <!-- Modal Includes -->
    <?php require_once 'registrar_producto.php'; ?>
    <?php require_once 'registrar_categoria.php'; ?>
    <?php require_once 'borro_definitivo.php'; ?>
    <?php require_once 'restaurar_producto.php'; ?>

    <!-- Scripts -->
    <script src="modal_editar.js"></script>
    <script src="activar_registrar.js"></script>
    <script src="activar_categoria.js"></script>
    <script src="soft_delete.js"></script>
    <script src="borro_definitivo.js"></script>
    <script src="restaurar_producto.js"></script>
</body>

</html>