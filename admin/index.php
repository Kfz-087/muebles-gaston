<?php

require_once __DIR__ . '/../config/conexion.php';

session_start();

if (isset($_SESSION['rol']) === '1') {
    header("Location: /muebles-gaston/admin/index.php");
    exit;
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== '1') {
    header("Location: /muebles-gaston/index.php");
    exit;
}

$usuario = $_SESSION['usuario'];

?>

<?php
require_once __DIR__ . '/../config/conexion.php';
$conn = conectar();

$sql = "SELECT * FROM clientes WHERE usuario = :usuario";
$registro = $conn->prepare($sql);
$registro->execute([
    ':usuario' => $_SESSION['usuario']
]);
$cliente = $registro->fetch(PDO::FETCH_ASSOC);

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
            p.fecha_inicio, 
            p.fecha_fin,
            p.activa,
            GROUP_CONCAT(producto.nombre SEPARATOR ', ') as productos_nombres,
            MIN(producto.ruta) as imagen_referencia,
            MIN(producto.precio) as precio_base
         FROM promociones p
         INNER JOIN promociones_productos pp ON p.id_promocion = pp.id_promocion
         INNER JOIN productos producto ON pp.id_producto = producto.id_producto
         WHERE p.fecha_fin >= CURDATE()
         GROUP BY p.id_promocion, p.nombre, p.descripcion, p.tipo_descuento, p.fecha_inicio, p.fecha_fin, p.activa";
$registro3 = $conn->prepare($sql3);
$registro3->execute();
$promociones = $registro3->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Distribuidora ProViveres - Inicio</title>
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

</head>
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
        <!-- TopAppBar -->
        <div class="home-header">

            <div style="display: flex; align-items: center; width: 3rem;">
                <span class="app-icon" style="font-size: 1.5rem;">menu</span>
            </div>
            <?php echo "<h3 class='brand-title'>Hola, $usuario </h3>"; ?>

            <div style="width: 3rem; display: flex; justify-content: flex-end;">
                <button id="carrito" class="btn-icon" style="padding: 0;">
                    <span class="app-icon" style="font-size: 1.5rem;">shopping_cart</span>
                </button>
            </div>
        </div>

        <!-- HeaderImage / Hero -->
        <div class="hero-container">
            <div class="hero-card" data-alt="High quality bulk burger patties and premium hot dog ingredients"
                style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0) 40%), url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoMNm0UEcqkvYfPDfPRvoHKQ3V16lDIdRikg&s");'>
                <div class="hero-content">
                    <p class="hero-title">Tu Carpintero de Confianza</p>
                    <p class="hero-subtitle">Los Mejores muebles de la argentina</p>
                </div>
            </div>
        </div>

        <!-- Headline & Who We Are -->
        <div class="info-section">
            <h3 class="section-headline"> Servicios de carpintería de la más alta calidad </h3>
            <p class="section-desc">
                Más de 20 años de experencia en el armado de muebles
        </div>

        <!-- SectionHeader: Productos Estrella -->
        <div class="section-header-row">
            <h2 class="section-title">Nuestras Promociones </h2>
            <span class="link-action">Ver Todo</span>
        </div>




        <?php
        // require_once __DIR__ . '/../includes/products.php';  
        require_once __DIR__ . '/../config/conexion.php';

        $conn = conectar();

        foreach ($promociones as $promocion) {
            echo " <div class='product-card-vertical'> ";
            echo " <div class='product-image-container'>
                <img src='" . ($promocion['imagen_referencia']) . "' style='width: 100%; height: 100%; object-fit: cover;'>";
            $badge_text = ucfirst(str_replace('_', ' ', $promocion['tipo_descuento']));
            echo "<span class='badge-overlay'>$badge_text</span>";

            echo " </div> ";
            echo " <div class='product-info-vertical'> ";
            echo " <p class='product-title-sm'>$promocion[nombre]</p> ";
            echo " <p class='product-meta' style='font-size: 0.8rem; color: #666;'>Incluye: $promocion[productos_nombres]</p> ";
            echo " <p class='product-meta'>$promocion[descripcion]</p> ";
            echo " <div class='price-row'> ";
            echo " <p class='price-main' style='color: var(--primary); font-weight: bold;'>¡Oferta!</p> ";

            echo " </div> ";
            echo " </div> ";
            echo " </div> ";
        }
        ?>
    </div>
    <!-- Información y Sucursales Section -->
    <div class="info-box">
        <h2 class="section-title" style="margin-bottom: 1rem; font-size: 1.25rem;">Información y Sucursales</h2>
        <div style="display: flex; flex-direction: column;">
            <div class="info-row">
                <span class="app-icon" style="color: var(--color-primary);">location_on</span>
                <div class="info-content">
                    <p class="info-title">Sede Central</p>
                    <p class="info-text">Av. Logística 450, Zona Industrial</p>
                    <p class="info-sub">Buenos Aires, Argentina</p>
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
                        <p class="info-text"><?php echo $horario['dia_semana']; ?>:
                            <?php
                            if ($horario['abierto'] == 1) {
                                echo $horario['hora_apertura'] . ' - ' . $horario['hora_cierre'];
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
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3301.580512364792!2d-58.32948125625436!3d-34.736069163360064!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95a32be4e427b0e7%3A0x73ae1571d646cdb9!2sCentro%20de%20Formacion%20Laboral%20N%C2%BA402%20%22Fray%20Luis%20Beltr%C3%A1n%22.%20Quilmes!5e0!3m2!1ses-419!2sar!4v1769450216850!5m2!1ses-419!2sar"
                width="100%" height="450" style="border:5px solid #ccc;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <button class="btn-contact">
            <span class="app-icon">chat_bubble</span>
            Contáctanos
        </button>
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
            <spa n class="nav-label">Catálogo</span>
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

    <script>
        if (localStorage.getItem('modo') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

</body>



</html>