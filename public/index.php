<?php
require_once __DIR__ . '/../config/conexion.php';
$conn = conectar();

$sql2 = "SELECT * FROM horarios";
$registro2 = $conn->prepare($sql2);
$registro2->execute();
$horarios = $registro2->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// Consulta compatible: Quitamos el filtro p.activa = 1 para que el administrador vea todo
$sql3 = "SELECT 
            p.id_promocion, 
            p.nombre, 
            p.descripcion, 
            p.tipo_descuento,
            p.valor_descuento, 
            p.fecha_inicio, 
            p.fecha_fin,
            p.activa,
            GROUP_CONCAT(producto.nombre SEPARATOR ', ') as productos_nombres,
            MIN(producto.ruta) as imagen_referencia,
            MIN(producto.precio) as precio_base
         FROM promociones p
         LEFT JOIN promociones_productos pp ON p.id_promocion = pp.id_promocion
         LEFT JOIN productos producto ON pp.id_producto = producto.id_producto
         WHERE p.fecha_fin >= CURDATE()
         GROUP BY 
            p.id_promocion, 
            p.nombre, 
            p.descripcion, 
            p.tipo_descuento,
            p.valor_descuento, 
            p.fecha_inicio, 
            p.fecha_fin,
            p.activa";
$registro3 = $conn->prepare($sql3);
$registro3->execute();
$promociones = $registro3->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gastón Carpintería y Diseño</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Link to our Semantic CSS -->
    <link href="styles.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="modal.css">
    <link rel="stylesheet" href="perfil.css">
    <link rel="stylesheet" href="promociones/modal_promos.css">

</head>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#d4af37",
                    "background-light": "#1c1917",
                    "background-dark": "#151311",
                },
                fontFamily: {
                    "display": ["Inter", "sans-serif"]
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

<body>
    <div style="display: flex; flex-direction: column; min-height: 100vh;">
        <!-- Sticky Header -->
        <div
            class="sticky top-0 z-50 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md px-4 py-3 flex items-center justify-between border-b border-[#44403c] dark:border-[#3d3920]">

            <h2
                class="text-[#fafaf9] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">
                Carpintería y Diseño
            </h2>

        </div>


        <!-- HeaderImage / Hero -->
        <div class="hero-container">
            <div class="hero-card" data-alt="High quality bulk burger patties and premium hot dog ingredients"
                style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0) 40%), url("/muebles-gaston/assets/productos/bac31eed-9953-4784-ad91-a4d08d54a548.jfif");'>
                <div class="hero-content">

                </div>
            </div>
        </div>

        <!-- Headline & Who We Are -->
        <div class="info-section">
            <h3 class="section-headline"> Más de 20 años de experiencia en la fabricación de muebles a medida </h3>

        </div>

        <!-- SectionHeader: Productos Estrella -->
        <div class="section-header-row">
            <h2 class="section-title">Nuestras Promociones </h2>
            <a href="catalogo/index.php" style="text-decoration:none"><span class="link-action">Ver Todo</span></a>

        </div>



        <div class='product-container' style="display:flex">
            <?php
            foreach ($promociones as $promocion) {

                echo " <div class='product-card-vertical' style='background-color: var(--color-bg-light); border-color: var(--color-border-light);'> ";
                echo " <div class='product-image-container'>
            <img src='" . ($promocion['imagen_referencia']) . "' style='width: 100%; height: 100%; object-fit: cover;'>";
                echo "<span class='badge-overlay' style='color: var(--text-main-dark);'> " . $promocion['valor_descuento'] . " Cuotas sin Interés </span>";
                echo " </div> ";
                echo " <div class='product-info-vertical'> ";
                echo " <p class='product-title-sm' style='color: var(--color-text-main-light);'>{$promocion['nombre']}</p> ";
                echo " <p class='product-meta' style='font-size: 0.8rem; color: var(--color-text-sec-light);'>Incluye: {$promocion['productos_nombres']}</p> ";
                // echo " <p class='product-meta'>{$promocion['descripcion']}</p> ";
                // echo " <div class='price-row'> ";
                // echo " <p class='price-main' style='color: var(--primary); font-weight: bold;'>¡Oferta!</p> ";
                // echo " </div> ";
                echo " </div> ";
                echo " </div> ";

            }
            ?>
        </div>

    </div>
    <!-- Información y Sucursales Section -->
    <div class="info-box"
        style="margin-bottom: 2rem; background-color: var(--color-bg-light); border-color:1px solid var(--color-border-light);">
        <h2 class="section-title" style="margin-bottom: 1rem; font-size: 1.25rem;">Información y Ubicación</h2>
        <div style="display: flex; flex-direction: column;">
            <div class="info-row">
                <span class="app-icon" style="color: var(--color-primary);">location_on</span>
                <div class="info-content">
                    <p class="info-title" style="color: var(--color-text-main-light);">Taller</p>
                    <p class="info-text" style="color: var(--color-text-main-light);">Lavalle 5045</p>
                    <p class="info-sub" style="color: var(--color-text-sec-light);">Ezpeleta, Quilmes, Pcia. de Buenos
                        Aires</p>
                </div>
            </div>
            <div class="info-row">
                <span class="app-icon" style="color: var(--color-primary);">schedule</span>

                <div class="info-content">



                    <div class="horarios_container" style="display: flex; justify-content: space-between; width: 100%;">
                        <p class="info-title">Horarios de Atención</p>
                        <!-- <button class="btn-icon" id="btn-horarios">
                            <span class='app-icon' style='font-size: 1.25rem; color: #9c8e49;'>edit</span>
                        </button> -->
                    </div>
                    <?php foreach ($horarios as $horario): ?>
                        <p class="info-text" style="color: var(--color-text-main-light);">
                            <?php echo $horario['dia_semana']; ?>:
                            <?php
                            if ($horario['abierto'] == 1) {
                                echo date('H:i', strtotime($horario['hora_apertura'])) . ' - ' . date('H:i', strtotime($horario['hora_cierre']));
                            } else {
                                echo 'Cerrado';
                            } ?>
                        </p>
                    <?php endforeach; ?>



                </div>
            </div>
        </div>
        <!--        Static Map Placeholder -->
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1159.0256067606088!2d-58.235446608524924!3d-34.75006402844277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95a32ee1f989fb5f%3A0x7a21caba8d9e2f2!2sLavalle%205045%2C%20B1882%20Ezpeleta%2C%20Provincia%20de%20Buenos%20Aires!5e0!3m2!1ses-419!2sar!4v1774286915998!5m2!1ses-419!2sar"
                width="100%" height="450" style="border:5px solid #ccc;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <a href="contactos/index.php" target="_blank" style="text-decoration: none;">
            <button class="btn-contact">
                <span class="app-icon">chat_bubble</span>
                Contáctanos
            </button>
        </a>
    </div>

    <!--        Bottom Navigation Spacer -->
    <div style="height: 6rem;"></div>

    <!--    Sticky Footer / Bottom Nav -->
    <div class="bottom-nav">
        <a href="index.php" class="nav-item active">
            <span class="app-icon" style="font-variation-settings: 'FILL' 1;">home</span>
            <span class="nav-label">Inicio</span>
        </a>
        <a href="catalogo/index.php" class="nav-item">
            <span class="app-icon">grid_view</span>
            <span class="nav-label">Catálogo</span>
        </a>

        <a href="multimedia/index.php" class="nav-item">
            <span class="app-icon">image</span>
            <span class="nav-label">Multimedia</span>
        </a>
        <a href="contactos/index.php" class="nav-item">
            <span class="app-icon">contacts</span>
            <span class="nav-label">Contactos</span>
        </a>
    </div>
    </div>

    <script>
        if (localStorage.getItem('modo') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>


</body>



</html>