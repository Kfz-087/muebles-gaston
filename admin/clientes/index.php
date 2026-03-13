<?php
session_start();

$usuario = $_SESSION['usuario'];
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != '1') {
    header("Location: ../index.php");
    exit();
}

require_once '../../config/conexion.php';
$conn = conectar();

$sql = "SELECT * FROM clientes";
$registro = $conn->prepare($sql);
$registro->execute();
$clientes = $registro->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM sucursales_clientes";
$registro2 = $conn->prepare($sql2);
$registro2->execute();
$sucursales = $registro2->fetchAll(PDO::FETCH_ASSOC);


               
            

?>

<!DOCTYPE html>

<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gestión de Clientes (Admin)</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&amp;display=swap"
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
                        "background-dark": "#121212",
                        "card-dark": "#1e1e1e",
                        "neutral-dark": "#2a2a2a",
                    },
                    fontFamily: {
                        "display": ["Work Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
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

        .fill-icon {
            font-variation-settings: 'FILL' 1;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
    <!-- Main Container (Mobile Frame) -->
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
        <!-- Header / Navigation Bar -->
        <header
            class="sticky top-0 z-10 flex items-center justify-between bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 py-4 border-b border-slate-200 dark:border-neutral-dark">
            <div class="flex items-center gap-2">
                <button onclick="window.location.href = '../index.php';"
                    class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-neutral-dark transition-colors">
                    <span class="material-symbols-outlined text-slate-900 dark:text-slate-100">arrow_back_ios_new</span>
                </button>
                <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-slate-100">Gestión de Clientes</h1>
            </div>
            <button
                class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-background-dark shadow-lg">
                <span class="material-symbols-outlined font-bold">person_add</span>
            </button>
        </header>
        <!-- Search and Filters Section -->
        <div class="px-4 py-4 space-y-4 bg-background-light dark:bg-background-dark">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <span
                        class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">search</span>
                </div>
                <input
                    class="block w-full rounded-xl border-none bg-slate-100 dark:bg-neutral-dark py-3 pl-10 pr-4 text-slate-900 dark:text-slate-100 placeholder-slate-500 focus:ring-2 focus:ring-primary focus:bg-white dark:focus:bg-card-dark transition-all"
                    placeholder="Buscar por nombre, usuario, etc." type="text" id="search-input" oninput="applyFilters()" />
            </div>

           
            <!-- Filter Chips -->
            <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1" id="filter-container">
                <button onclick="applyFilter('all', this)"
                    class="filter-btn shrink-0 flex h-9 items-center justify-center rounded-full bg-primary px-5 text-sm font-semibold text-background-dark">
                    Todos
                </button>
                <button onclick="applyFilter('1', this)"
                    class="filter-btn shrink-0 flex h-9 items-center justify-center rounded-full bg-slate-100 dark:bg-neutral-dark px-5 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-neutral-800 transition-colors">
                    Activos
                </button>
                <button onclick="applyFilter('0', this)"
                    class="filter-btn shrink-0 flex h-9 items-center justify-center rounded-full bg-slate-100 dark:bg-neutral-dark px-5 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-neutral-800 transition-colors">
                    Inactivos
                </button>
                <button onclick="applyFilter('new', this)"
                    class="filter-btn shrink-0 flex h-9 items-center justify-center rounded-full bg-slate-100 dark:bg-neutral-dark px-5 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-neutral-800 transition-colors">
                    Nuevos
                </button>
            </div>
        </div>
        <!-- Client List Section -->
        <main class="flex-1 px-4 py-2 space-y-3 pb-24">
            <!-- Client Cards -->
            <?php foreach ($clientes as $cliente): ?>
                <div
                    data-status="<?php echo $cliente['activo']; ?>"
                    data-id="<?php echo $cliente['id_cliente']; ?>"
                    data-search="<?php echo strtolower($cliente['nombre'] . ' ' . $cliente['usuario'] . ' ' . $cliente['apellido'] . ' ' . $cliente['correo']); ?>"
                    class="client-card flex flex-col gap-3 rounded-xl bg-white dark:bg-card-dark p-4 border border-slate-100 dark:border-neutral-dark shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/20 text-primary">
                                <span class="material-symbols-outlined text-3xl">storefront</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-slate-100 leading-tight">
                                    <?php echo $cliente['nombre']; ?>
                                </h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Nombre de Usuario:
                                    <?php echo $cliente['usuario']; ?>
                                </p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Contraseña:
                                    <?php echo $cliente['contrasena']; ?>
                                </p>
                            </div>
                        </div>
                        <div id="badge-container-<?php echo $cliente['id_cliente']; ?>">
                            <?php if ($cliente['activo'] == 1): ?>
                                <span class="inline-flex items-center rounded-full bg-primary/10 px-2 py-0.5 text-xs font-bold text-primary border border-primary/20 uppercase tracking-wider">
                                    Activo
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-neutral-800 px-2 py-0.5 text-xs font-bold text-slate-500 border border-slate-200 dark:border-neutral-700 uppercase tracking-wider">
                                    Inactivo
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="h-px bg-slate-100 dark:bg-neutral-dark w-full"></div>
                    <div class="flex items-center justify-between">
                        <div class="text-sm">
                            <p class="text-slate-400 text-xs uppercase font-semibold tracking-tighter">Representante</p>
                            <p class="text-slate-700 dark:text-slate-300 font-medium">
                                <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?>
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <button id="btn-editar" data-id="<?php echo $cliente['id_cliente']; ?>"
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-50 dark:bg-neutral-dark text-slate-600 dark:text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                            <label id="label-<?php echo $cliente['id_cliente']; ?>"
                                class="relative flex h-7 w-12 cursor-pointer items-center rounded-full <?php echo $cliente['activo'] == 1 ? 'bg-primary justify-end' : 'bg-slate-300 dark:bg-neutral-700 justify-start'; ?> p-0.5 transition-all duration-300">
                                <div class="h-6 w-6 rounded-full bg-white shadow-sm"></div>
                                <input type="checkbox" name="activo" 
                                    onchange="toggleCliente(<?php echo $cliente['id_cliente']; ?>, this.checked)"
                                    <?php echo $cliente['activo'] == 1 ? 'checked' : ''; ?> class="sr-only">
                                <span class="material-symbols-outlined text-[20px] absolute <?php echo $cliente['activo'] == 1 ? 'left-1' : 'right-1'; ?> text-white opacity-0">check</span>
                            </label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>













            
            <!-- <div
                class="flex flex-col gap-3 rounded-xl bg-white dark:bg-card-dark p-4 border border-slate-100 dark:border-neutral-dark shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-slate-100 dark:bg-neutral-dark text-slate-400">
                            <span class="material-symbols-outlined text-3xl">fastfood</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-slate-100 leading-tight">Hot Dogs La Calle
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">NIT: 830.455.901-2</p>
                        </div>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full bg-slate-100 dark:bg-neutral-800 px-2 py-0.5 text-xs font-bold text-slate-500 border border-slate-200 dark:border-neutral-700 uppercase tracking-wider">
                        Inactivo
                    </span>
                </div>
                <div class="h-px bg-slate-100 dark:bg-neutral-dark w-full"></div>
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <p class="text-slate-400 text-xs uppercase font-semibold tracking-tighter">Representante</p>
                        <p class="text-slate-700 dark:text-slate-300 font-medium">Maria Rodriguez</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <button
                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-50 dark:bg-neutral-dark text-slate-600 dark:text-slate-400">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </button>
                        <label
                            class="relative flex h-7 w-12 cursor-pointer items-center rounded-full bg-slate-300 dark:bg-neutral-700 p-0.5 justify-start">
                            <div class="h-6 w-6 rounded-full bg-white shadow-sm"></div>
                            <input class="sr-only" type="checkbox" />
                        </label>
                    </div>
                </div>
            </div>
            
            <div
                class="flex flex-col gap-3 rounded-xl bg-white dark:bg-card-dark p-4 border border-slate-100 dark:border-neutral-dark shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/20 text-primary">
                            <span class="material-symbols-outlined text-3xl">lunch_dining</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-slate-100 leading-tight">Burguer Point Central
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">NIT: 912.334.551-0</p>
                        </div>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full bg-primary/10 px-2 py-0.5 text-xs font-bold text-primary border border-primary/20 uppercase tracking-wider">
                        Activo
                    </span>
                </div>
                <div class="h-px bg-slate-100 dark:bg-neutral-dark w-full"></div>
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <p class="text-slate-400 text-xs uppercase font-semibold tracking-tighter">Representante</p>
                        <p class="text-slate-700 dark:text-slate-300 font-medium">Juan Camilo Soto</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <button
                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-50 dark:bg-neutral-dark text-slate-600 dark:text-slate-400">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </button>
                        <label
                            class="relative flex h-7 w-12 cursor-pointer items-center rounded-full bg-primary p-0.5 justify-end">
                            <div class="h-6 w-6 rounded-full bg-white shadow-sm"></div>
                            <input checked="" class="sr-only" type="checkbox" />
                        </label>
                    </div>
                </div>
            </div>
            
            <div
                class="flex flex-col gap-3 rounded-xl bg-white dark:bg-card-dark p-4 border border-slate-100 dark:border-neutral-dark shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/20 text-primary">
                            <span class="material-symbols-outlined text-3xl">local_pizza</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-slate-100 leading-tight">Pizza &amp; Burguer
                                House</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">NIT: 800.221.001-4</p>
                        </div>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full bg-primary/10 px-2 py-0.5 text-xs font-bold text-primary border border-primary/20 uppercase tracking-wider">
                        Activo
                    </span>
                </div>
                <div class="h-px bg-slate-100 dark:bg-neutral-dark w-full"></div>
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <p class="text-slate-400 text-xs uppercase font-semibold tracking-tighter">Representante</p>
                        <p class="text-slate-700 dark:text-slate-300 font-medium">Diana Marín</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <button
                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-50 dark:bg-neutral-dark text-slate-600 dark:text-slate-400">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </button>
                        <label
                            class="relative flex h-7 w-12 cursor-pointer items-center rounded-full bg-primary p-0.5 justify-end">
                            <div class="h-6 w-6 rounded-full bg-white shadow-sm"></div>
                            <input checked="" class="sr-only" type="checkbox" />
                        </label>
                    </div>
                </div>
            </div>   -->
            
        </main> 
        
        <!-- Bottom Navigation Bar -->
        <nav
            class="fixed bottom-0 left-0 right-0 z-20 border-t border-slate-200 dark:border-neutral-dark bg-white/95 dark:bg-background-dark/95 backdrop-blur-lg px-4 pb-6 pt-2">
            <div class="flex items-center justify-around max-w-md mx-auto">
                <a class="flex flex-col items-center gap-1 text-slate-400" href="../pedidos/index.php">
                    <span class="material-symbols-outlined text-2xl">assignment_turned_in</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Pedidos</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-primary" href="index.php">
                    <span class="material-symbols-outlined text-2xl fill-icon">group</span>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Clientes</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-slate-400" href="../perfil/stock/index.php">
                    <span class="material-symbols-outlined text-2xl">inventory_2</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest">Stock</span>
                </a>
                <form action="../perfil/ventas/index.php" method="post">
                    <input type="hidden" name="cliente_id" value=" <?php echo $cliente['usuario']; ?>">
                    <button type="submit" class="flex flex-col items-center gap-1 text-slate-400">
                        <span class="material-symbols-outlined text-2xl">monitoring</span>
                        <span class="text-[10px] font-medium uppercase tracking-widest">Ventas</span>
                    </button>
                </form>
                <form action="../perfil/index.php" method="post">
                    <input type="hidden" name="usuario" value=" <?php echo $cliente['usuario']; ?>">
                    <button type="submit" class="flex flex-col items-center gap-1 text-slate-400">
                        <span class="material-symbols-outlined text-2xl">settings</span>
                        <span class="text-[10px] font-medium uppercase tracking-widest">Ajustes</span>
                    </button>
                </form>
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
                b.classList.add('bg-slate-100', 'dark:bg-neutral-dark', 'font-medium', 'text-slate-600', 'dark:text-slate-400');
            });
            btn.classList.add('bg-primary', 'font-semibold', 'text-background-dark');
            btn.classList.remove('bg-slate-100', 'dark:bg-neutral-dark', 'font-medium', 'text-slate-600', 'dark:text-slate-400');

            applyFilters();
        }

        function applyFilters() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const cards = document.querySelectorAll('.client-card');
            
            let newIds = [];
            if (currentFilter === 'new') {
                const allIds = Array.from(cards).map(c => parseInt(c.dataset.id)).sort((a,b) => b-a);
                newIds = allIds.slice(0, 2);
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

        function toggleCliente(id, checked) {
            const label = document.getElementById('label-' + id);
            const badgeContainer = document.getElementById('badge-container-' + id);
            const card = label.closest('.client-card');
            const activo = checked ? 1 : 0;

            // Visual update immediately
            if (checked) {
                label.classList.remove('bg-slate-300', 'dark:bg-neutral-700', 'justify-start');
                label.classList.add('bg-primary', 'justify-end');
            } else {
                label.classList.remove('bg-primary', 'justify-end');
                label.classList.add('bg-slate-300', 'dark:bg-neutral-700', 'justify-start');
            }

            // AJAX call
            const formData = new FormData();
            formData.append('id_cliente', id);
            formData.append('activo', activo);

            fetch('activar_cliente.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update data-status for filtering
                    card.dataset.status = activo;
                    
                    // Update badge
                    if (checked) {
                        badgeContainer.innerHTML = `<span class="inline-flex items-center rounded-full bg-primary/10 px-2 py-0.5 text-xs font-bold text-primary border border-primary/20 uppercase tracking-wider">Activo</span>`;
                    } else {
                        badgeContainer.innerHTML = `<span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-neutral-800 px-2 py-0.5 text-xs font-bold text-slate-500 border border-slate-200 dark:border-neutral-700 uppercase tracking-wider">Inactivo</span>`;
                    }
                } else {
                    alert('Error: ' + data.message);
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la solicitud');
                location.reload();
            });
        }
    </script>
    <!-- Background Decoration -->
    <div class="fixed top-0 right-0 -z-10 h-64 w-64 bg-primary/5 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 -z-10 h-64 w-64 bg-primary/5 blur-[120px] rounded-full pointer-events-none"></div>
</body>

</html>