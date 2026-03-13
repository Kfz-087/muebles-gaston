<?php

require_once __DIR__ . '/../../../config/conexion.php';

$conn = conectar();

$sql = "SELECT * FROM productos LEFT JOIN categoria ON productos.id_categoria = categoria.id_categoria";
$registro = $conn->prepare($sql);
$registro->execute();
$productos = $registro->fetchAll(PDO::FETCH_ASSOC);

$count = "SELECT COUNT(*) as total FROM productos LEFT JOIN categoria ON productos.id_categoria = categoria.id_categoria";
$registro = $conn->prepare($count);
$registro->execute();
$total = $registro->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gestión de Inventario (Admin)</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&amp;display=swap"
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
                        "primary": "#f2cc0d",
                        "background-light": "#f8f8f5",
                        "background-dark": "#221f10",
                    },
                    fontFamily: {
                        "display": ["Work Sans"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        body {
            font-family: 'Work Sans', sans-serif;
            min-height: max(884px, 100dvh);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .active-icon {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
    <div class="relative flex min-h-screen flex-col overflow-x-hidden">
        <header
            class="sticky top-0 z-50 flex items-center bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md p-4 border-b border-slate-200 dark:border-slate-800 justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="text-slate-900 dark:text-slate-100 flex size-10 items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer">
                    <span class="material-symbols-outlined">arrow_back</span>
                </div>
                <h1 class="text-lg font-bold tracking-tight">Gestión de Inventario</h1>
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="flex size-10 items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-slate-700">
                    <span class="material-symbols-outlined">add_box</span>
                </button>
            </div>
        </header>
        <section class="flex flex-wrap gap-4 p-4">
            <div
                class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-5 bg-white dark:bg-slate-800 shadow-sm border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Stock
                        Crítico</p>
                    <span class="material-symbols-outlined text-red-500">warning</span>
                </div>
                <p class="text-slate-900 dark:text-white text-3xl font-bold leading-tight">12</p>
                <p class="text-slate-400 text-xs">Productos bajo el mínimo</p>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-5 bg-primary shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-slate-900 text-xs font-bold uppercase tracking-wider">Valor Inventario</p>
                    <span class="material-symbols-outlined text-slate-900">inventory</span>
                </div>
                <p class="text-slate-900 text-2xl font-bold leading-tight">$3.42M</p>
                <p class="text-slate-800/60 text-xs font-medium">842 SKU activos</p>
            </div>
        </section>
        <section class="px-4 py-2">
            <div class="relative flex items-center mb-4">
                <span class="material-symbols-outlined absolute left-3 text-slate-400">search</span>
                <input
                    class="w-full bg-white dark:bg-slate-800 border-none rounded-lg pl-10 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary shadow-sm"
                    placeholder="Buscar producto o código..." type="text" />
            </div>
            <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                <button
                    class="flex items-center gap-2 px-4 py-2 bg-primary text-slate-900 rounded-full whitespace-nowrap shadow-sm">
                    <span class="text-sm font-bold">Todos</span>
                </button>
                <button
                    class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full whitespace-nowrap shadow-sm">
                    <span class="text-sm font-medium">Panes</span>
                </button>
                <button
                    class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full whitespace-nowrap shadow-sm">
                    <span class="text-sm font-medium">Carnes</span>
                </button>
                <button
                    class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full whitespace-nowrap shadow-sm">
                    <span class="text-sm font-medium">Salchichas</span>
                </button>
            </div>
        </section>








        <section class="flex-1 px-4 pb-24">
            <div class="flex items-center justify-between mb-3 mt-4">
                <h2 class="text-lg font-bold">Listado de Productos</h2>
                <span class="text-xs font-medium text-slate-500 uppercase tracking-widest">128 SKU</span>
            </div>
            <div class="space-y-3">

                <div <?php foreach ($productos as $producto) ?>
                    class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col gap-3">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-3">
                            <div
                                class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-slate-400">
                                    <img class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center"
                                        src="<?php echo $producto['ruta']; ?>" alt="<?php echo $producto['nombre']; ?>">
                                </span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-slate-100">
                                    <?php echo $producto['nombre']; ?>
                                </h3>
                                <p class="text-xs text-slate-500">Categoría:
                                    <?php echo $producto['nombre_categoria']; ?>
                                    •
                                    SKU: <?php echo $producto['sku']; ?>
                                </p>
                                <div
                                    class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 uppercase tracking-tight">
                                    <span class="material-symbols-outlined text-[14px]">report</span> Stock Crítico
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-red-600 dark:text-red-400">15</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Cajas</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-700">
                        <div class="text-[11px] text-slate-500">
                            Mínimo: <span class="font-bold">50 Cajas</span>
                        </div>
                        <button
                            class="bg-primary text-slate-900 px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1">
                            AJUSTAR <span class="material-symbols-outlined text-sm">edit</span>
                        </button>
                    </div>
                </div>


                <div
                    class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col gap-3">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-3">
                            <div
                                class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-slate-400">set_meal</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-slate-100">Carne Res Premium 150g</h3>
                                <p class="text-xs text-slate-500">Categoría: Carnes • SKU: C-042</p>
                                <div
                                    class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 uppercase tracking-tight">
                                    Normal
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-slate-900 dark:text-slate-100">450</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Unidades</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-700">
                        <div class="text-[11px] text-slate-500">
                            Mínimo: <span class="font-bold">100 Unid.</span>
                        </div>
                        <button
                            class="bg-primary text-slate-900 px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1">
                            AJUSTAR <span class="material-symbols-outlined text-sm">edit</span>
                        </button>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col gap-3">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-3">
                            <div
                                class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-slate-400">straighten</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-slate-100">Salchicha Frankfurt 22cm</h3>
                                <p class="text-xs text-slate-500">Categoría: Salchichas • SKU: S-112</p>
                                <div
                                    class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 uppercase tracking-tight">
                                    Próximo a agotar
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-slate-900 dark:text-slate-100">85</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Paquetes</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-700">
                        <div class="text-[11px] text-slate-500">
                            Mínimo: <span class="font-bold">80 Paq.</span>
                        </div>
                        <button
                            class="bg-primary text-slate-900 px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1">
                            AJUSTAR <span class="material-symbols-outlined text-sm">edit</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>






















        <nav
            class="fixed bottom-0 left-0 right-0 z-50 bg-white/90 dark:bg-slate-900/90 backdrop-blur-lg border-t border-slate-200 dark:border-slate-800 pb-safe">
            <div class="flex items-center justify-around h-16">
                <a class="flex flex-col items-center justify-center gap-1 text-slate-400" href="#">
                    <span class="material-symbols-outlined">home</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Inicio</span>
                </a>
                <a class="flex flex-col items-center justify-center gap-1 text-slate-400" href="#">
                    <span class="material-symbols-outlined">bar_chart</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Ventas</span>
                </a>
                <a class="flex flex-col items-center justify-center gap-1 text-slate-400" href="#">
                    <span class="material-symbols-outlined">group</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Clientes</span>
                </a>
                <a class="flex flex-col items-center justify-center gap-1 text-primary" href="#">
                    <span class="material-symbols-outlined active-icon">inventory_2</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Stock</span>
                </a>
                <a class="flex flex-col items-center justify-center gap-1 text-slate-400" href="#">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Ajustes</span>
                </a>
            </div>
        </nav>
    </div>

</body>

</html>