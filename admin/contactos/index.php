<?php

require_once __DIR__ . '/../../config/conexion.php';

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== '1') {
    header("Location: ../../index.php");
    exit;
}

$conn = conectar();

// $sql = "SELECT * FROM clientes WHERE usuario = :usuario";
// $registro = $conn->prepare($sql);
// $registro->execute([
//     ':usuario' => $_SESSION['usuario']
// ]);
// $cliente = $registro->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gastón Carpintería y Diseño | Contactos </title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700;800;900&amp;display=swap"
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
                        "primary-fixed-dim": "rgb(124, 61, 50)",
                        "outline": "#44403c",
                        "on-surface-variant": "#475569",
                        "surface-bright": "#292524",
                        "tertiary": "#00687b",
                        "on-secondary": "#fafaf9",
                        "outline-variant": "#cbd5e1",
                        "tertiary-fixed": "#adecff",
                        "on-secondary-fixed-variant": "#544606",
                        "surface-variant": "#eae2d0",
                        "surface-tint": "#705d00",
                        "on-tertiary-fixed": "#001f26",
                        "on-error-container": "#93000a",
                        "surface-dim": "#e1d9c8",
                        "on-secondary-fixed": "#221b00",
                        "error-container": "#ffdad6",
                        "on-tertiary-container": "#006172",
                        "on-error": "#ffffff",
                        "background": "#1c1917",
                        "on-primary-container": "#685700",
                        "on-primary": "#0f172a",
                        "error": "#ba1a1a",
                        "on-tertiary": "#ffffff",
                        "surface-container-highest": "#eae2d0",
                        "tertiary-container": "#5bdfff",
                        "secondary-fixed": "#f8e295",
                        "inverse-primary": "#e9c400",
                        "surface-container-lowest": "#0a0a0a",
                        "surface-container-high": "#f0e7d6",
                        "primary-container": "#f2cc0d",
                        "primary-fixed": "#ffe16e",
                        "primary": "#d4af37",
                        "surface": "#292524",
                        "instagram": "linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)",
                        "whatsapp": "#25D366",
                        "facebook": "#104b99ff",
                        "gmail": "#DB4437",
                        "on-secondary-container": "#f2cc0d",
                        "secondary-container": "#1e293b",
                        "inverse-on-surface": "#f8f0de",
                        "on-primary-fixed-variant": "#544600",
                        "surface-container": "#f5eddb",
                        "on-primary-fixed": "#221b00",
                        "on-surface": "#fafaf9",
                        "on-background": "#fafaf9",
                        "secondary": "#292524",
                        "on-tertiary-fixed-variant": "#004e5d",
                        "inverse-surface": "#1e293b",
                        "secondary-fixed-dim": "#dac67c",
                        "tertiary-fixed-dim": "#50d6f6",
                        "surface-container-low": "#151311"
                    },
                    fontFamily: {
                        "headline": ["Work Sans"],
                        "body": ["Work Sans"],
                        "label": ["Work Sans"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
                hover: {
                    "instagram": "#E1306C",
                    "whatsapp": "#25D366",
                    "facebook": "#104b99ff",
                    "gmail": "#DB4437",
                    "translate": "translateY(-5px)",
                }
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
    </style>
</head>

<body class="bg-background text-on-background min-h-screen flex flex-col">
    <!-- TopAppBar -->
    <header>
        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-50 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-[#44403c] dark:border-[#3d3920]">
            <div class="text-[#fafaf9] dark:text-white flex size-12 shrink-0 items-center">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </div>
            <h2
                class="text-[#fafaf9] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">
                Contactos
            </h2>
            <div class="flex w-12 items-center justify-end">
                <button
                    class="relative flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 bg-transparent text-[#fafaf9] dark:text-white gap-2 text-base font-bold leading-normal tracking-[0.015em] min-w-0 p-0">
                    <span id="carrito_boton" class="material-symbols-outlined text-2xl">shopping_cart</span>
                </button>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="flex-grow pt-24 pb-32 px-6 max-w-md mx-auto w-full">
        <!-- Profile Header Section -->
        <section class="flex flex-col items-center text-center mb-10">
            <div class="relative mb-6">
                <div class="absolute -inset-1 bg-primary rounded-full blur-sm opacity-30 w-48 h-48"></div>
                <img alt="Profile Picture"
                    class="relative w-48 h-48 rounded-full border-4 border-primary-container object-cover shadow-lg"
                    src="/muebles-gaston/assets/perfil/044f065d-16cb-4ba3-84c7-755d074ad0cf.jpg" />
            </div>
            <h1 class="text-2xl font-black tracking-tighter text-on-surface mb-1"> Gastón Rostro </h1>
            <p class="text-on-surface-variant font-medium text-sm tracking-tight uppercase">Carpintería y Diseño</p>
        </section>
        <!-- Action Links Vertical Stack -->
        <div class="flex flex-col gap-4">
            <!-- Instagram -->
            <a class="group relative flex items-center justify-between w-full p-5 bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 text-on-primary rounded-xl transition-all duration-200 active:scale-95 shadow-sm hover:translate-y-[-5px]"
                href="https://www.instagram.com/gaston.rostro?igsh=MWNhc2F5eWVkNTVrMQ==" target="_blank">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-2xl" data-icon="camera_alt"> camera_alt</span>
                    <span class="font-bold tracking-tight text-sm uppercase">Instagram</span>
                </div>
                <span class="material-symbols-outlined opacity-50 group-hover:opacity-100 transition-opacity"
                    data-icon="north_east">north_east</span>
            </a>



            <!-- WhatsApp -->
            <a class="group relative flex items-center justify-between w-full p-5 bg-whatsapp text-on-surface border-2 border-on-surface rounded-xl transition-all duration-200 active:scale-95 shadow-sm hover:translate-y-[-5px]"
                href="https://wa.me/5491169794003" target="_blank" title="Chatear por WhatsApp" id="wsp-btn">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" viewBox="0 0 24 24">
                        <path fill="#ffffff"
                            d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.23 8.23 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.39-4.19-1.15l-.3-.17l-3.12.82l.83-3.04l-.2-.32a8.2 8.2 0 0 1-1.26-4.38c.01-4.54 3.7-8.24 8.25-8.24M8.53 7.33c-.16 0-.43.06-.66.31c-.22.25-.87.86-.87 2.07c0 1.22.89 2.39 1 2.56c.14.17 1.76 2.67 4.25 3.73c.59.27 1.05.42 1.41.53c.59.19 1.13.16 1.56.1c.48-.07 1.46-.6 1.67-1.18s.21-1.07.15-1.18c-.07-.1-.23-.16-.48-.27c-.25-.14-1.47-.74-1.69-.82c-.23-.08-.37-.12-.56.12c-.16.25-.64.81-.78.97c-.15.17-.29.19-.53.07c-.26-.13-1.06-.39-2-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.12-.24-.01-.39.11-.5c.11-.11.27-.29.37-.44c.13-.14.17-.25.25-.41c.08-.17.04-.31-.02-.43c-.06-.11-.56-1.35-.77-1.84c-.2-.48-.4-.42-.56-.43c-.14 0-.3-.01-.47-.01" />
                    </svg>
                    <span class="font-bold tracking-tight text-sm uppercase">WhatsApp</span>
                </div>
                <span class="material-symbols-outlined opacity-50 group-hover:opacity-100 transition-opacity"
                    data-icon="north_east">north_east</span>
            </a>


            <a class="group relative flex items-center justify-between w-full p-5 bg-gmail text-primary rounded-xl transition-all duration-200 active:scale-95 shadow-lg hover:translate-y-[-5px]"
                href="mailto:gastonrostro46@gmail.com">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-2xl" data-icon="mail">mail</span>
                    <span class="font-bold tracking-tight text-sm uppercase"> Gmail </span>
                </div>
                <span class="material-symbols-outlined opacity-50 group-hover:opacity-100 transition-opacity"
                    data-icon="north_east">north_east</span>
            </a>



        </div>
        <!-- Metric Cluster (Bento Style) -->
        <!-- <div class="grid grid-cols-2 gap-4 mt-10">
            <div class="bg-surface-container p-5 rounded-xl border-l-4 border-primary">
                <span
                    class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-1">Network</span>
                <span class="text-2xl font-black text-on-surface">12.4K+</span>
            </div>
            <div class="bg-secondary p-5 rounded-xl">
                <span class="block text-[10px] font-black uppercase tracking-widest text-primary mb-1">Status</span>
                <span class="text-sm font-bold text-white uppercase tracking-tighter flex items-center gap-1">
                    <span class="w-2 h-2 bg-primary rounded-full"></span> Available
                </span>
            </div>
        </div> -->
    </main>
    <!--        Bottom Navigation Spacer -->
    <div style="height: 6rem;"></div>

    <!--    Sticky Footer / Bottom Nav -->
    <nav>
        <div class="bottom-nav">
            <a href="../index.php" class="nav-item">
                <span class="app-icon" style="font-variation-settings: 'FILL' 1;">home</span>
                <span class="nav-label">Inicio</span>
            </a>
            <a href="../catalogo/index.php" class="nav-item">
                <span class="app-icon">grid_view</span>
                <span class="nav-label">Catálogo</span>
            </a>
            <a href="../multimedia/index.php" class="nav-item">
                <span class="app-icon">image</span>
                <span class="nav-label">Multimedia</span>
            </a>
            <a href="index.php" class="nav-item active">
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
    </nav>
    <script src="../../auth/logout.js"></script>
</body>

</html>