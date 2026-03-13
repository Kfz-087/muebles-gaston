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

echo "$usuario ";
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
            <h2 class="brand-title">Muebles Gastón</h2>
            <div style="width: 3rem; display: flex; justify-content: flex-end;">
                <button id="carrito" class="btn-icon" style="padding: 0;">
                    <span class="app-icon" style="font-size: 1.5rem;">shopping_cart</span>
                </button>
            </div>
        </div>

        <!-- HeaderImage / Hero -->
        <div class="hero-container">
            <div class="hero-card" data-alt="High quality bulk burger patties and premium hot dog ingredients"
                style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0) 40%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuA2L-etsCy75P6zISCdvSRFFFXyJNZaFKGjpyG5E4n9v_FuaahVLUxAfmOyCaGnRUAPZuwZ_lujS0ZLcR5YTslbuBmKbBSNYw1Xzo7tCmJGD_Wdp0FV3i7H444-SJvCXimLtZP9tzoN5UukUnu25MSkWJfkYoM5qB8qwkGpCGn4s0tbT3WgqeadhJJY33tb5G5veLkbhRJyv9fIYApq53aiTcDGLWvczMG5Ea1_ZjpGqVi50CqGZFipQjrRYJN0MV6fIbOMkQZmWYWN");'>
                <div class="hero-content">
                    <p class="hero-title">Tu Proveedor de Confianza</p>
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
            $categories = ['Todos', 'hamburguesas' => 'Hamburguesas', 'pan_hamburguesas' => 'Pan de Hamburguesas', 'pan_panchos' => 'Pan de Panchos', 'salchichas' => 'Salchichas', 'aderezos' => 'Aderezos', 'bebidas' => 'Bebidas'];

            foreach ($categories as $cat):
                $isActive = ($currentCategory === $cat) ? 'active' : '';
                $url = ($cat === 'Todos') ? 'index.php' : 'index.php?categoria=' . urlencode($cat);
                ?>
                <a href="<?php echo $url; ?>" class="category-btn <?php echo $isActive; ?>"
                    style="text-decoration: none; color: white; display: inline-flex;">
                    <p><?php echo htmlspecialchars($cat); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
        // require_once __DIR__ . '/../includes/products.php';  
        require_once __DIR__ . '/../config/conexion.php';

        $conn = conectar();

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



                echo " <div class='product-card-vertical'> ";
                echo " <div class='product-image-container' style='background-image: url($producto[ruta]);'> ";
                if ($producto['destacado'] == 1) {
                    echo "<span class='badge-overlay'>Más Vendido</span>";
                }
                echo " </div> ";
                echo " <div class='product-info-vertical'> ";
                echo " <p class='product-title-sm'>$producto[nombre]</p> ";
                echo " <p class='product-meta'>$producto[descripcion]</p> ";
                echo " <div class='price-row'> ";
                echo " <p class='price-main'>$ $producto[precio]</p> ";

                echo " </div> ";
                // echo " <button class='btn-add-cart-sm'> ";
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