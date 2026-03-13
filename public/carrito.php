<?php
// Ensure session is started if not already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if $cliente is available from parent scope, otherwise try to fetch it if session exists
// Check if $cliente is available from parent scope, otherwise try to fetch it if session exists
if (!isset($cliente) && isset($_SESSION['usuario'])) {
    if (!function_exists('conectar')) {
        require_once __DIR__ . '/../config/conexion.php';
    }
    // We might need a connection if not provided
    if (!isset($conn)) {
        $conn = conectar();
    }

    // Fetch cliente if we have ID in session, or username logic if needed
    if (isset($_SESSION['id_cliente'])) {
        $sql = "SELECT * FROM clientes WHERE id_cliente = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $_SESSION['id_cliente']]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// ALWAYS try to fetch branches if we have a client ID (either from session or $cliente)
$clientIdForBranches = $cliente['id_cliente'] ?? $_SESSION['id_cliente'] ?? null;

if ($clientIdForBranches) {
    if (!isset($conn)) {
        if (!function_exists('conectar')) {
            require_once __DIR__ . '/../config/conexion.php';
        }
        $conn = conectar();
    }

    $sql2 = "SELECT * FROM sucursales_clientes WHERE id_cliente = :id";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([':id' => $clientIdForBranches]);
    $sucursales = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html class="dark" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
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
    <div id="modal_carrito">
        <!-- Modal Backdrop Emulation -->
        <div class="modal-backdrop"></div>

        <!-- Bottom Sheet Modal -->
        <div class="bottom-sheet">
            <!-- BottomSheetHandle -->
            <div class="sheet-handle-container">
                <div class="sheet-handle"></div>
            </div>


            <!-- TopAppBar -->
            <div class="sheet-header">
                <h2 class="sheet-title">Tu Pedido</h2>
                <button class="btn-icon">
                    <span id="cerrar_carrito" class="app-icon">close</span>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="cart-items-container">
                <?php
                $total = 0;
                if (!empty($_SESSION['carrito'])) {
                    foreach ($_SESSION['carrito'] as $id => $item) {
                        $subtotalItem = $item['precio'] * $item['cantidad'];
                        $total += $subtotalItem;
                        ?>
                        <div class="cart-item">
                            <div class="item-image"
                                style='background-image: url("<?php echo htmlspecialchars($item['imagen']); ?>");'></div>
                            <div class="item-details">
                                <p class="item-name">
                                    <?php echo htmlspecialchars($item['nombre']); ?>
                                </p>
                                <p class="item-price">$
                                    <?php echo number_format($item['precio'], 3); ?> <span
                                        style="font-size: 0.75rem; opacity: 0.6;">/ unit</span>
                                </p>
                            </div>
                            <div class="quantity-control">
                                <button class="btn-qty minus" data-id="<?php echo $id; ?>"
                                    data-cantidad="<?php echo $item['cantidad']; ?>">-</button>
                                <input class="qty-input" type="number" value="<?php echo $item['cantidad']; ?>" readonly />
                                <button class="btn-qty plus" data-id="<?php echo $id; ?>"
                                    data-cantidad="<?php echo $item['cantidad']; ?>">+</button>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p style='text-align:center; padding: 2rem; color: #888;'>Tu carrito está vacío.</p>";
                }

                $iva = $total * 0.21;
                $finalTotal = $total + $iva;
                ?>
            </div>

            <!-- Sticky Footer Summary Section -->
            <div class="cart-summary">
                <!-- DescriptionList -->
                <div>
                    <div class="summary-row">
                        <p class="summary-label">Subtotal</p>
                        <p class="summary-value">$
                            <?php echo number_format($total, 3); ?>
                        </p>
                    </div>
                    <div class="summary-row">
                        <p class="summary-label">IVA (21%)</p>
                        <p class="summary-value">$
                            <?php echo number_format($iva, 3); ?>
                        </p>
                    </div>
                    <div class="summary-total">
                        <p class="total-label">Total</p>
                        <p class="total-value">$
                            <?php echo number_format($finalTotal, 3); ?>
                        </p>
                    </div>
                </div>

                <div style="margin: 1rem 0;">
                    <?php if (!empty($sucursales)) { ?>
                        <label for="sucursal" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Seleccionar
                            Sucursal:</label>
                        <select id="sucursal" name="sucursal"
                            style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                            <?php foreach ($sucursales as $sucursal): ?>
                                <option value="<?php echo $sucursal['id_sucursal']; ?>">
                                    <?php echo htmlspecialchars($sucursal['nombre_sucursal'] ?? $sucursal['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php } else { ?>
                        <p style="color: #666; font-size: 0.9rem;">No hay sucursales registradas.</p>
                    <?php } ?>
                </div>

                <!-- Main CTA Button -->
                <?php if (isset($cliente['id_cliente'])) { ?>
                    <button id="confirmar-pedido" class="btn-checkout"
                        data-id-cliente="<?php echo $cliente['id_cliente']; ?>">
                        <span>Confirmar Pedido</span>
                        <span class="app-icon" style="font-weight: 700;">arrow_forward</span>
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

<script src="pedidos/procesar.js"></script>

</html>