<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
require_once __DIR__ . '/../../../config/conexion.php';

$conn = conectar();

$sql = "SELECT * FROM clientes";
$registro = $conn->prepare($sql);
$registro->execute();
$clientes = $registro->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM sucursales_clientes";
$registro2 = $conn->prepare($sql2);
$registro2->execute();
$sucursales = $registro2->fetchAll(PDO::FETCH_ASSOC);

$sql3 = "SELECT * FROM pedidos LEFT JOIN clientes ON pedidos.id_cliente = clientes.id_cliente LEFT JOIN sucursales_clientes ON pedidos.id_sucursal = sucursales_clientes.id_sucursal ORDER BY fecha_ingreso DESC";
$registro3 = $conn->prepare($sql3);
$registro3->execute();
$pedidos = $registro3->fetchAll(PDO::FETCH_ASSOC);

$countprecio = $conn->prepare("SELECT COALESCE(SUM(precio), 0) AS precio_total FROM pedidos WHERE DATE(fecha_ingreso) = CURRENT_DATE");
$countprecio->execute();
$count_total = $countprecio->fetchColumn();

$countmes = $conn->prepare("SELECT COALESCE(SUM(precio), 0) AS precio_total FROM pedidos WHERE MONTH(fecha_ingreso) = MONTH(CURRENT_DATE()) AND YEAR(fecha_ingreso) = YEAR(CURRENT_DATE())");
$countmes->execute();
$count_totalmes = $countmes->fetchColumn();

$countanio = $conn->prepare("SELECT COALESCE(SUM(precio), 0) AS precio_total FROM pedidos WHERE YEAR(fecha_ingreso) = YEAR(CURRENT_DATE())");
$countanio->execute();
$count_totalanio = $countanio->fetchColumn();
?>

<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gestión de Ventas (Admin)</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
    <style>
        body {
            font-family: 'Work Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .active-icon {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
    <!-- Main Container -->
    <div class="relative flex min-h-screen flex-col overflow-x-hidden">
        <!-- Header -->
        <header
            class="sticky top-0 z-50 flex items-center bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md p-4 border-b border-slate-200 dark:border-slate-800 justify-between">
            <div class="flex items-center gap-3">
                <form action="../index.php" method="post">
                    <input type="hidden" name="usuario" value=" <?php echo $usuario; ?>">
                    <button type="submit"
                        class="text-slate-900 dark:text-slate-100 flex size-10 items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </button>
                </form>
                </a>
                <h1 class="text-lg font-bold tracking-tight">Gestión de Ventas</h1>
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="flex size-10 items-center justify-center rounded-full hover:bg-slate-200 dark:hover:bg-slate-700">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
            </div>
        </header>

        <!-- Summary Cards -->
        <section class="flex flex-wrap gap-4 p-4">
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-5 bg-primary shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-slate-900 text-sm font-semibold uppercase tracking-wider">Ventas de Hoy</p>
                    <span class="material-symbols-outlined text-slate-800">today</span>
                </div>
                <p class="text-slate-900 text-3xl font-bold leading-tight">$
                    <?php echo $count_total; ?>
                </p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-green-700 text-sm">trending_up</span>
                    <p class="text-green-700 text-sm font-bold">+12.5% vs ayer</p>
                </div>
            </div>
            <div
                class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-5 bg-slate-900 dark:bg-slate-800 shadow-sm border border-slate-700">
                <div class="flex items-center justify-between">
                    <p class="text-primary text-sm font-semibold uppercase tracking-wider">Ventas del Mes</p>
                    <span class="material-symbols-outlined text-primary">calendar_month</span>
                </div>
                <p class="text-white text-3xl font-bold leading-tight">$
                    <?php echo $count_totalmes; ?>
                </p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-primary text-sm">trending_up</span>
                    <p class="text-primary text-sm font-bold">+5.2% vs mes ant.</p>
                </div>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-5 bg-slate-900 dark:bg-slate-800 shadow-sm border border-slate-700"
                style="background-color:#800923; border:1px solid #cf2248">
                <div class="flex items-center justify-between">
                    <p class="text-white text-sm font-semibold uppercase tracking-wider">Ventas del Año</p>
                    <span class="material-symbols-outlined text-white">calendar_month</span>
                </div>
                <p class="text-white text-3xl font-bold leading-tight">$
                    <?php echo $count_totalanio; ?>
                </p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-white text-sm">trending_up</span>
                    <p class="text-white text-sm font-bold">+5.2% vs mes ant.</p>
                </div>
            </div>
        </section>
        <!-- Search and Filters -->
        <section class="px-4 py-2">
            <div class="relative flex items-center mb-4">
                <span class="material-symbols-outlined absolute left-3 text-slate-400">search</span>
                <input
                    class="w-full bg-white dark:bg-slate-800 border-none rounded-lg pl-10 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary shadow-sm"
                    placeholder="Buscar por cliente o ID..." id="search-input" type="text" oninput="applyFilters()" />
            </div>
            <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar" id="filter-container">
                <button onclick="applyFilter('all', this)"
                    class="filter-btn shrink-0 flex h-9 items-center justify-center rounded-full bg-primary px-5 text-sm font-semibold text-background-dark shadow-sm">
                    Todos
                </button>
                <button onclick="applyFilter('pendiente', this)"
                    class="filter-btn shrink-0 flex h-9 items-center justify-center rounded-full bg-white dark:bg-slate-800 px-5 text-sm font-medium text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors shadow-sm">
                    Pendientes
                </button>
                <button onclick="applyFilter('entregado', this)"
                    class="filter-btn shrink-0 flex h-9 items-center justify-center rounded-full bg-white dark:bg-slate-800 px-5 text-sm font-medium text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors shadow-sm">
                    Entregados
                </button>
                <button onclick="applyFilter('new', this)"
                    class="filter-btn shrink-0 flex h-9 items-center justify-center rounded-full bg-white dark:bg-slate-800 px-5 text-sm font-medium text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors shadow-sm">
                    Nuevos
                </button>
            </div>
        </section>
        <section class="flex-1 px-4 pb-24">
            <div class="flex items-center justify-between mb-3 mt-4">
                <h2 class="text-lg font-bold">Transacciones Recientes</h2>
                <span
                    class="text-xs font-medium text-slate-500 uppercase tracking-widest"><?php echo count($pedidos); ?>
                    Resultados</span>
            </div>
            <div class="space-y-3">
                <!-- Transaction List -->
                <?php if (empty($pedidos)): ?>
                    <div
                        class="text-center py-10 text-slate-500 bg-white dark:bg-slate-800 rounded-xl border border-dashed border-slate-300 dark:border-slate-700">
                        No hay transacciones registradas
                    </div>
                <?php else: ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <div data-id="<?php echo $pedido['id_pedido']; ?>" data-status="<?php echo $pedido['estado']; ?>"
                            data-search="<?php echo strtolower($pedido['id_pedido'] . ' ' . ($pedido['nombre_sucursal'] ?? '') . ' ' . $pedido['nombre'] . ' ' . $pedido['apellido']); ?>"
                            class="order-card bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col gap-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs font-bold text-primary uppercase tracking-tighter">
                                        #ORD-<?php echo $pedido['id_pedido']; ?></p>
                                    <h3 class="font-bold text-slate-900 dark:text-slate-100">
                                        <?php echo htmlspecialchars($pedido['nombre_sucursal'] ?? 'Sin Sucursal'); ?>
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-1">
                                        <?php echo date('d M Y • H:i', strtotime($pedido['fecha_ingreso'])); ?> •
                                        <?php echo htmlspecialchars($pedido['nombre'] . ' ' . $pedido['apellido']); ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                        $<?php echo number_format($pedido['precio'], 0, ',', '.'); ?></p>
                                    <?php
                                    $estadoClasses = [
                                        '0' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
                                        '1' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'entregado' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'en_preparacion' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'pendiente' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        'en_camino' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
                                    ];
                                    $estadoLabel = [
                                        '0' => 'Pendiente',
                                        '1' => 'Entregado',
                                        'entregado' => 'Entregado',
                                        'en_preparacion' => 'En Preparación',
                                        'pendiente' => 'Pendiente',
                                        'en_camino' => 'En Camino',
                                        'cancelado' => 'Cancelado'
                                    ];
                                    $class = $estadoClasses[$pedido['estado']] ?? 'bg-slate-100 text-slate-800';
                                    $label = $estadoLabel[$pedido['estado']] ?? $pedido['estado'];
                                    ?>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo $class; ?>"><?php echo $label; ?></span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-700">
                                <div class="flex items-center gap-1 text-slate-500">
                                    <span class="material-symbols-outlined text-sm">payments</span>
                                    <span class="text-xs font-medium">Pedido #<?php echo $pedido['id_pedido']; ?></span>
                                </div>
                                <button class="text-primary text-xs font-bold flex items-center gap-1">
                                    DETALLES <span class="material-symbols-outlined text-sm">chevron_right</span>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
        <!-- Bottom Navigation Bar -->




        <nav
            class="fixed bottom-0 left-0 right-0 z-20 border-t border-slate-200 dark:border-neutral-dark bg-white/95 dark:bg-background-dark/95 backdrop-blur-lg px-4 pb-6 pt-2">
            <div class="flex items-center justify-around max-w-md mx-auto">
                <a class="flex flex-col items-center gap-1 text-slate-400" href="#">
                    <span class="material-symbols-outlined text-2xl">assignment_turned_in</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Pedidos</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-slate-400" href="#">
                    <span class="material-symbols-outlined text-2xl fill-icon">group</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Clientes</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-slate-400" href="../stock/index.php">
                    <span class="material-symbols-outlined text-2xl">inventory_2</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Stock</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-primary" href="#">
                    <span class="material-symbols-outlined text-2xl">monitoring</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Ventas</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-slate-400" href="#">
                    <span class="material-symbols-outlined text-2xl">settings</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Ajustes</span>
                </a>
            </div>
        </nav>
    </div>

    <script>
        let currentFilter = 'all';

        function applyFilter(filter, btn) {
            currentFilter = filter;
            // Update button styles
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('bg-primary', 'font-semibold', 'text-background-dark');
                b.classList.add('bg-white', 'dark:bg-slate-800', 'font-medium', 'text-slate-600', 'dark:text-slate-400');
            });
            btn.classList.add('bg-primary', 'font-semibold', 'text-background-dark');
            btn.classList.remove('bg-white', 'dark:bg-slate-800', 'font-medium', 'text-slate-600', 'dark:text-slate-400');

            applyFilters();
        }

        function applyFilters() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const cards = document.querySelectorAll('.order-card');

            let newIds = [];
            if (currentFilter === 'new') {
                const allIds = Array.from(cards).map(c => parseInt(c.dataset.id)).sort((a, b) => b - a);
                newIds = allIds.slice(0, 5); // Show top 5 newest orders
            }

            cards.forEach(card => {
                const matchesSearch = card.dataset.search.includes(searchTerm);
                let matchesFilter = false;

                if (currentFilter === 'all') {
                    matchesFilter = true;
                } else if (currentFilter === 'new') {
                    matchesFilter = newIds.includes(parseInt(card.dataset.id));
                } else {
                    matchesFilter = card.dataset.status === currentFilter;
                }

                card.style.display = (matchesSearch && matchesFilter) ? 'flex' : 'none';
            });
        }
    </script>
</body>

</html>