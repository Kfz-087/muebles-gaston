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
            <form action="index.php" method="get" class="w-full">
                <input type="hidden" name="categoria"
                    value="<?php echo htmlspecialchars(isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos'); ?>">
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
                        <div
                            class="text-[#9c8e49] flex border-none bg-white dark:bg-[#322e1a] items-center justify-center pr-4 rounded-r-xl">
                            <span class="material-symbols-outlined text-xl">tune</span>
                        </div>
                    </div>
                </label>
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
                            <!-- <p class="text-[#1c190d] dark:text-white text-sm font-bold leading-tight line-clamp-2">
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                            </p> -->
                            <!-- <p class="text-[#9c8e49] text-[11px] font-semibold mt-1 line-clamp-1">
                                <?php echo htmlspecialchars($producto['descripcion']); ?>
                            </p> -->
                            <!-- <div class="mt-2 mb-3">
                                <p class="text-[#1c190d] dark:text-white text-lg font-extrabold leading-none">
                                    $<?php echo ($producto['precio']); ?></p>
                                <p class="text-[#9c8e49] text-[11px] font-medium">Mayorista</p>
                            </div> -->
                            <!-- <button
                                class="btn-add-cart-sm mt-auto w-full flex h-9 items-center justify-center gap-2 rounded-lg bg-primary text-white text-xs font-bold transition-all hover:bg-primary/90">
                                <span class="material-symbols-outlined text-sm">add_shopping_cart</span> Añadir
                            </button> -->
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
            <a href="taller/index.php" class="nav-item">
                <span class="app-icon">build</span>
                <span class="nav-label">Taller</span>
            </a>
            <a href="multimedia/index.php" class="nav-item">
                <span class="app-icon">image</span>
                <span class="nav-label">Multimedia</span>
            </a>
            <a href="contactos/index.php" class="nav-item">
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