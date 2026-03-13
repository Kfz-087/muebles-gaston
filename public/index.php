<?php require_once __DIR__ . '/../config/conexion.php'; ?>
<?php require_once __DIR__ . '/../auth/check.php'; ?>


<?php

$nombre = $_SESSION['usuario'];
echo "bienvenido, $nombre";

$conn = conectar();

$sql = "SELECT * FROM clientes WHERE usuario = :nombre";
$preparar = $conn->prepare($sql);
$preparar->execute([':nombre' => $nombre]);
$cliente = $preparar->fetch(PDO::FETCH_ASSOC);

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
</head>

<body>
    <div style="display: flex; flex-direction: column; min-height: 100vh;">
        <!-- TopAppBar -->
        <div class="home-header">
            <div style="display: flex; align-items: center; width: 3rem;">
                <span class="app-icon" style="font-size: 1.5rem;">menu</span>
            </div>
            <h2 class="brand-title">Frami</h2>
            <div style="width: 3rem; display: flex; justify-content: flex-end;">
                <button id="carrito" class="btn-icon" style="padding: 0;">
                    <span class="app-icon" style="font-size: 1.5rem;">shopping_cart</span>
                </button>
            </div>
        </div>

        <!-- HeaderImage / Hero -->
        <div class="hero-container">
            <div class="hero-card"
                style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0) 40%), url("../assets/pictures/muebles.jpg");'>

                <div class="hero-content">
                    <p class="hero-title">Muebles Gaston</p>
                    <p class="hero-subtitle">Suministro mayorista de alta calidad.</p>
                </div>
            </div>
        </div>

        <!-- Headline & Who We Are -->
        <div class="info-section">
            <h3 class="section-headline">Distribución Mayorista Premium</h3>
            <p class="section-desc">
                Somos líderes en el suministro de insumos para hamburgueserías y cadenas de comida rápida. Nos
                especializamos en logística B2B con calidad garantizada en cada bulto.
            </p>
        </div>

        <!-- SectionHeader: Productos Estrella -->
        <div class="section-header-row">
            <h2 class="section-title">Nuestros Productos Estrella</h2>
            <span class="link-action">Ver Todo</span>
        </div>



        <div class="scroll-container" style="padding: 0 1rem 0.5rem 1rem;">
            <?php
            $currentCategory = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos';
            $categories = ['Todos', 'hamburguesas', 'pan_hamburguesas', 'pan_panchos', 'salchichas', 'aderezos', 'bebidas'];

            foreach ($categories as $cat):
                $isActive = ($currentCategory === $cat) ? 'active' : '';
                $url = ($cat === 'Todos') ? 'index.php' : 'index.php?categoria=' . urlencode($cat);
                ?>
                <a href="<?php echo $url; ?>" class="category-btn <?php echo $isActive; ?>"
                    style="text-decoration: none; color: inherit; display: inline-flex;">
                    <p><?php echo htmlspecialchars($cat); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
        // require_once __DIR__ . '/../includes/products.php';
        // require_once __DIR__ . '/../config/conexion.php'; // Moved to top
        


        // 1. Capture inputs
        $search = isset($_POST['search_input']) ? trim($_POST['search_input']) : '';
        $category = isset($_GET['categoria']) ? $_GET['categoria'] : 'Todos';

        // 2. Build Query
        // Use LEFT JOIN to ensure we can filter by category name, but still get product details
        $sql = "SELECT p.* FROM productos p LEFT JOIN categoria c ON p.id_categoria = c.id_categoria WHERE p.activo AND p.destacado=1";
        $params = [];

        // Logic: Search takes priority. If no search, check category.
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

            echo " <div class='product-grid'> ";
            foreach ($productos as $producto) {

                if ($producto['destacado'] == 1) {
                    echo "<span class='badge-overlay'>Más Vendido</span>";
                }

                echo " <div class='product-card-vertical'> ";
                echo " <div class='product-image-container' style='background-image: url($producto[ruta]);'> ";
                echo " </div> ";
                echo " <div class='product-info-vertical'> ";
                echo " <p class='product-title-sm'>$producto[nombre]</p> ";
                echo " <p class='product-meta'>$producto[descripcion]</p> ";
                // echo " <div class='price-row'> ";
                // echo " <p class='price-main'>$ $producto[precio]</p> ";
        
                // echo " </div> ";s
                // echo " <button class='btn-add-cart-sm' data-id='$producto[id_producto]'> ";
                // echo " <span class='app-icon' style='font-size: 1rem;'>add_shopping_cart</span> Añadir al carrito ";
                // echo " </button> ";
                echo " </div> ";
                echo " </div> ";
            }
            echo " </div> ";
        } else {
            echo "No se encontraron productos";
        } ?>
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
                    <p class="info-title">Horarios de Atención</p>
                    <p class="info-text">Lunes a Viernes: 08:00 - 18:00</p>
                    <p class="info-text">Sábados: 09:00 - 13:00</p>
                </div>
            </div>
        </div>
        <!-- Static Map Placeholder -->
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

    <!-- Bottom Navigation Spacer -->
    <div style="height: 6rem;">
        <!-- Sticky Footer / Bottom Nav -->
        <div class="bottom-nav">
            <a href="index.php" class="nav-item active">
                <span class="app-icon" style="font-variation-settings: 'FILL' 1;">home</span>
                <span class="nav-label">Inicio</span>
            </a>
            <a href="catalogo/index.php" class="nav-item">
                <span class="app-icon">grid_view</span>
                <span class="nav-label">Catálogo</span>
            </a>

            <a href="../index.php" class="nav-item">
                <span class="app-icon">person</span>
                <span class="nav-label">Iniciar Sesión</span>
            </a>


        </div>
    </div>




    <!-- <script src="carrito.js"></script> -->
</body>

</html>