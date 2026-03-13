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
            <form action="index.php" method="post" class="w-full">
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
                            name="search_input" placeholder="Buscar productos..." />
                        <div
                            class="text-[#9c8e49] flex border-none bg-white dark:bg-[#322e1a] items-center justify-center pr-4 rounded-r-xl">
                            <span class="material-symbols-outlined text-xl">tune</span>
                        </div>
                    </div>
                </label>
            </form>
        </div>

        <!-- Create Product Button -->
        <!-- <div class="px-4 mb-2">
            <button type="button"
                class="w-full flex h-10 items-center justify-center gap-2 rounded-xl bg-primary text-white text-sm font-bold shadow-sm"
                id="crear_producto">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                Crear Producto
            </button>
        </div> -->

        <!-- Category Filters -->
        <div class="flex gap-3 p-4 overflow-x-auto hide-scrollbar whitespace-nowrap">
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

                // Prettify label (replace _ with space and capitalize)
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
            <h3 class="text-[#1c190d] dark:text-white text-lg font-extrabold">Populares por Mayor</h3>
            <button class="text-sm font-semibold text-[#9c8e49]">Ver todo</button>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 p-4">
            <?php
            // 1. Capture inputs
            $search = isset($_POST['search_input']) ? trim($_POST['search_input']) : '';
            $category = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos';

            // 2. Build Query
            $sql = "SELECT p.* FROM productos p LEFT JOIN categoria c ON p.id_categoria  = c.id_categoria WHERE p.activo=1";
            $params = [];

            if (!empty($search)) {
                $sql .= " AND p.nombre LIKE :search";
                $params[':search'] = "%$search%";
            } elseif ($category !== 'Todos' && !empty($category)) {
                $sql .= " AND c.nombre = :categoria";
                $params[':categoria'] = $category;
            }

            // 3. Prepare and Execute
            $preparar = $conn->prepare($sql);
            $preparar->execute($params);
            $productos = $preparar->fetchAll(PDO::FETCH_ASSOC);

            if ($preparar->rowCount() > 0) {
                foreach ($productos as $producto) {
                    ?>
                    <div
                        class="flex flex-col gap-2 pb-4 bg-white dark:bg-[#2a2715] rounded-xl overflow-hidden shadow-sm border border-[#e8e4d8] dark:border-[#3d3920]">
                        <div class="relative w-full aspect-square bg-center bg-no-repeat bg-cover"
                            style="background-image: url('<?php echo htmlspecialchars($producto['ruta']); ?>');">

                            <?php if ($producto['destacado'] == 1): ?>
                                <span
                                    class="absolute top-2 left-2 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Más
                                    Vendido</span>
                            <?php endif; ?>


                        </div>

                        <div class="px-3 py-1 flex flex-col flex-1">
                            <p class="text-[#1c190d] dark:text-white text-sm font-bold leading-tight line-clamp-2">
                                <?php echo htmlspecialchars($producto['nombre']); ?>
                            </p>
                            <p class="text-[#9c8e49] text-[11px] font-semibold mt-1 line-clamp-1">
                                <?php echo htmlspecialchars($producto['descripcion']); ?>
                            </p>
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