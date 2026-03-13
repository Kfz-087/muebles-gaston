<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Mis Pedidos Expandido</title>
    <!-- Link to our Semantic CSS -->
    <link href="../styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="modal.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
</head>


<?php

require_once __DIR__ . '/../../config/conexion.php';

$search = isset($_POST['search']) && !empty(trim($_POST['search'])) ? trim($_POST['search']) : '';

if ($search) {
    // Search mode: filter by ID
    $sql = "
SELECT
p.id_pedido,
p.estado,
p.precio as total_pedido,
p.fecha_ingreso,
pp.cantidad,
prod.nombre as nombre_producto,
prod.ruta as imagen_producto,
c.nombre as nombre_cliente,
c.apellido as apellido_cliente
FROM pedidos p
LEFT JOIN productos_pedidos pp ON p.id_pedido = pp.id_pedido
LEFT JOIN productos prod ON pp.id_producto = prod.id_producto
LEFT JOIN clientes c ON p.id_cliente = c.id_cliente
WHERE p.id_pedido LIKE :search
ORDER BY p.fecha_ingreso DESC";
} else {
    // No search: show all orders
    $sql = "
SELECT
p.id_pedido,
p.estado,
p.precio as total_pedido,
p.fecha_ingreso,
pp.cantidad,
prod.nombre as nombre_producto,
prod.ruta as imagen_producto,
c.nombre as nombre_cliente,
c.apellido as apellido_cliente
FROM pedidos p
LEFT JOIN productos_pedidos pp ON p.id_pedido = pp.id_pedido
LEFT JOIN productos prod ON pp.id_producto = prod.id_producto
LEFT JOIN clientes c ON p.id_cliente = c.id_cliente
ORDER BY p.fecha_ingreso DESC";
}

$conn = conectar();
$stmt = $conn->prepare($sql);

// Execute with or without search parameter
if ($search) {
    $stmt->execute([':search' => '%' . $search . '%']);
} else {
    $stmt->execute();
}

$resultados = $stmt->fetchAll();

// Group results by order ID since the JOIN returns one row per item
$pedidos_agrupados = [];
foreach ($resultados as $row) {
    $id = $row['id_pedido'];
    if (!isset($pedidos_agrupados[$id])) {
        $pedidos_agrupados[$id] = [
            'id_pedido' => $row['id_pedido'],
            'estado' => $row['estado'],
            'total' => $row['total_pedido'],
            'fecha' => $row['fecha_ingreso'],
            'cliente' => $row['nombre_cliente'],
            'apellido' => $row['apellido_cliente'],
            'items' => []
        ];
    }
    // Add item if it exists (check if nombre_producto is not null)
    if ($row['nombre_producto']) {
        $pedidos_agrupados[$id]['items'][] = [
            'nombre' => $row['nombre_producto'],
            'cantidad' => $row['cantidad']
        ];
    }
}
?>

<body>
    <div style="display: flex; flex-direction: column; min-height: 100vh;">
        <!-- Top Navigation Bar -->
        <header class="top-nav">
            <a href="../index.php" class="nav-back-btn">
                <span class="app-icon" style="font-size: 1.5rem;">arrow_back_ios</span>
            </a>
            <h2 class="nav-title">Mis Pedidos</h2>
            <div style="width: 3rem; display: flex; justify-content: flex-end;">
                <button class="btn-icon">
                    <span class="app-icon">filter_list</span>
                </button>
            </div>
        </header>

        <main style="flex: 1;">
            <!-- Search Bar -->
            <section class="search-section">
                <form method="POST" action="index.php">
                    <div class="search-container">
                        <div class="search-icon-box">
                            <span class="app-icon">search</span>
                        </div>
                        <input type="text" class="search-input" placeholder="Buscar por ID o fecha..." name="search" />
                    </div>
                </form>
            </section>

            <?php


            // $id_cliente = $_SESSION['id_cliente'];
// Retrieve all orders with their items
// Using LEFT JOIN to ensure we get orders even if they have no items (though they should)
// We order by order date descending
            // Check if search has a value (not just if it's set)
            



            ?>

            <!-- Status Chips (Category Filter) -->
            <section class="filter-section">

                <?php
                $currentCategory = isset($_GET['estado']) ? $_GET['estado'] : 'Todos';
                $categories = ['Todos', 'pendiente' => 'Pendientes', 'en_preparacion' => 'En Preparación', 'en_camino' => 'En Camino', 'entregado' => 'Entregado'];

                foreach ($categories as $cat):
                    $isActive = ($currentCategory === $cat) ? 'active' : '';
                    $url = ($cat === 'Todos') ? 'index.php' : 'index.php?estado=' . urlencode($cat);
                    ?>
                    <a href="<?php echo $url; ?>" class="category-btn <?php echo $isActive; ?>"
                        style="text-decoration: none; color: inherit; display: inline-flex;">
                        <p><?php echo htmlspecialchars($cat); ?></p>
                    </a>
                <?php endforeach; ?>
            </section>



            <!-- Order Cards Container -->
            <div class="orders-list">
                <?php if (empty($pedidos_agrupados)): ?>
                    <div style="padding: 2rem; text-align: center; color: #666;">
                        <p>No se encontraron pedidos.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($pedidos_agrupados as $pedido): ?>
                        <?php
                        // Determine styles/text based on status
                        $status_class = '';
                        $status_text = 'PENDIENTE'; // Default text
                        $card_class = 'order-card'; // Default card class
                        $icon = 'pending';

                        // Map DB enum status to UI
                        // Enum: 'pendiente','en_preparacion','en_camino','entregado'
                        // Also handling '0' just in case existing bad data needs to show up
                        switch ($pedido['estado']) {
                            case 'entregado':
                                $status_text = 'ENTREGADO';
                                $card_class .= ' delivered';
                                $icon = 'check_circle';
                                break;
                            case 'en_camino':
                                $status_text = 'EN CAMINO';
                                $status_class = 'status-badge'; // Usually active style
                                $icon = 'local_shipping';
                                break;
                            case 'en_preparacion':
                                $status_text = 'EN PREPARACIÓN';
                                $icon = 'inventory_2';
                                break;
                            case 'cancelled': // If ever added to enum
                            case 'cancelado':
                                $status_text = 'CANCELADO';
                                $card_class .= ' cancelled';
                                $icon = 'cancel';
                                break;
                            default: // pendiente or '0'
                                $status_text = 'PENDIENTE';
                                $icon = 'pending';
                                break;
                        }

                        // Format Date
                        $dateObj = new DateTime($pedido['fecha']);
                        $dateFormatted = $dateObj->format('d M, Y • h:i A');
                        $cliente = $pedido['cliente'] . ' ' . $pedido['apellido'];

                        ?>

                        <div class="<?php echo $card_class; ?>">
                            <!-- If active/en_camino, we often show an image header. For now, using standard layout for all unless strict requirement changes -->

                            <div class="order-content">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <p class="order-meta-date"><?php echo $dateFormatted; ?></p>
                                    <p class="order-meta-date">
                                        <?php echo $cliente; ?>
                                    </p>
                                    <span
                                        class="status-badge <?php echo ($pedido['estado'] == 'entregado' ? 'delivered' : ($pedido['estado'] == 'cancelado' ? 'cancelled' : '')); ?>">
                                        <button class="status-badge btn-confirmar-pedido"
                                            data-id="<?php echo $pedido['id_pedido'] ?>"
                                            data-status="<?php echo $pedido['estado']; ?>">
                                            <span class="app-icon"
                                                style="font-size: 0.875rem; margin-right: 4px; vertical-align: middle;"><?php echo $icon; ?></span>
                                            <?php echo $status_text; ?>
                                        </button>
                                    </span>
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                    <div>
                                        <p class="order-title">Pedido #<?php echo $pedido['id_pedido']; ?></p>

                                        <div class="order-items-preview" style="margin-top: 0.5rem;">
                                            <?php
                                            // Show first 2 items
                                            $itemCount = count($pedido['items']);
                                            $shown = 0;
                                            foreach ($pedido['items'] as $item) {
                                                if ($shown >= 2)
                                                    break;
                                                echo '<p class="order-item-text" style="font-size: 0.875rem; color: #555;">';
                                                echo '<span class="order-item-bold">' . $item['cantidad'] . 'x</span> ' . htmlspecialchars($item['nombre']);
                                                echo '</p>';
                                                $shown++;
                                            }
                                            // If more items, show "+ X more"
                                            if ($itemCount > 2) {
                                                echo '<p class="order-more-text" style="font-size: 0.8rem; margin-top: 2px;">+ ' . ($itemCount - 2) . ' artículos más</p>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div style="text-align: right; min-width: 80px;">
                                        <p style="font-size: 1.125rem; font-weight: 700; color: #1c190d;"
                                            class="dark:text-[#fcfbf8]">
                                            $<?php echo number_format($pedido['total'], 2); ?>
                                        </p>
                                        <button
                                            style="background: none; border: none; color: #9c8e49; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-top: 0.5rem; cursor: pointer;">
                                            Ver Detalles
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <!-- Bottom Navigation Bar -->
        <nav class="bottom-nav">
            <a href="../index.php" class="nav-item">
                <span class="app-icon">home</span>
                <span class="nav-label">Inicio</span>
            </a>
            <a href="../catalogo/index.php" class="nav-item">
                <span class="app-icon">grid_view</span>
                <span class="nav-label">Catálogo</span>
            </a>

            <a href="index.php" class="nav-item active">
                <span class="app-icon" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
                <span class="nav-label">Pedidos</span>
            </a>
            <form action="../perfil/index.php" method="post">
                <button type="submit" class="nav-item">
                    <input type="hidden" name="usuario" value="<?php echo $usuario['usuario']; ?>">
                    <span class="app-icon">person</span>
                    <span class="nav-label">Perfil</span>
                </button>
            </form>
        </nav>



</body>
<?php require_once 'modal_status.php'; ?>
<script src="status_pedidos.js"></script>

</html>