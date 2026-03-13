<?php

$usuario = $_POST['usuario'];
$_SESSION['usuario'] = $usuario;

if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../../config/conexion.php';
$conn = conectar();

$sql = "SELECT * FROM clientes WHERE usuario = :usuario";
$registro = $conn->prepare($sql);
$registro->execute([
    ':usuario' => $_SESSION['usuario']
]);
$cliente = $registro->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) as total_sucursales FROM sucursales_clientes WHERE id_cliente = :id_cliente";
$registro = $conn->prepare($sql);
$registro->execute([
    ':id_cliente' => $cliente['id_cliente']
]);
$total_sucursales = $registro->fetch(PDO::FETCH_ASSOC)['total_sucursales'];

$sql2 = "SELECT * FROM sucursales_clientes WHERE id_cliente = :id_cliente";
$registro2 = $conn->prepare($sql2);
$registro2->execute([
    ':id_cliente' => $cliente['id_cliente']
]);
$sucursales = $registro2->fetchAll(PDO::FETCH_ASSOC);

$sql3 = "SELECT COUNT(*) as total_pedidos FROM pedidos WHERE id_cliente = :id_cliente";
$registro3 = $conn->prepare($sql3);
$registro3->execute([
    ':id_cliente' => $cliente['id_cliente']
]);
$total_pedidos = $registro3->fetch(PDO::FETCH_ASSOC)['total_pedidos'];

?>

<!DOCTYPE html>
<html class="dark" lang="es">


<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Perfil Pro-Dashboard</title>
    <!-- Link to our Semantic CSS -->
    <link href="../styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="modal.css">
    <link rel="stylesheet" href="perfil.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
</head>

<body>
    <div id="main-wrapper">
        <!-- Top Navigation Bar -->
        <div class="top-nav">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <a href="../index.php" style="text-decoration: none; display: flex;">
                    <span class="app-icon" style="color: inherit;">arrow_back</span>
                </a>
            </div>
            <h2 class="nav-title">Perfil Pro-Dashboard</h2>
            <div style="display: flex; align-items: center; justify-content: flex-end;">
                <button class="btn-icon">
                    <span class="app-icon">settings</span>
                </button>
            </div>
        </div>

        <main class="profile-container">
            <!-- Profile Header Section -->
            <div class="profile-header">
                <div class="profile-avatar-container">
                    <div class="profile-avatar" style="background-image: url('<?php echo $cliente['imagen'] ?>');">
                    </div>
                    <!-- Verified Badge -->
                    <div class="verified-badge">
                        <span class="app-icon" style="font-size: 0.875rem; font-weight: 700;">verified</span>
                    </div>
                </div>

                <div style="text-align: center;">
                    <p class="profile-name">
                        <?php echo $cliente['nombre']; ?>
                    </p>
                    <div class="profile-badge-row">
                        <span class="role-badge">Distribuidor Mayorista</span>
                        <span class="profile-id">ID: B2B-992834</span>
                    </div>
                    <p class="profile-location">
                        <span class="app-icon" style="font-size: 0.875rem;">location_on</span>
                        <?php echo $cliente['direccion'] . ', ' . $cliente['localidad']; ?>
                    </p>
                </div>


                <button class="btn-edit-profile" id="btn-editar" data-id="<?php echo $cliente['id_cliente']; ?>">
                    <span class="app-icon" style="font-size: 1.125rem;">edit</span>
                    <span>Editar Perfil</span>
                </button>
            </div>

            <!-- Stats Quick-Strip -->
            <div class="stats-strip">
                <div class="stat-card">
                    <p class="stat-label">Pedidos Activos</p>
                    <div class="stat-value-row">
                        <p class="stat-value">
                            <?php echo $total_pedidos; ?>
                        </p>
                        <span class="app-icon stat-icon">shopping_cart</span>
                    </div>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Límite de Crédito</p>
                    <div class="stat-value-row">
                        <p class="stat-value">$15k</p>
                        <span class="app-icon stat-icon">payments</span>
                    </div>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Días de Crédito</p>
                    <div class="stat-value-row">
                        <p class="stat-value">30</p>
                        <span class="app-icon stat-icon">calendar_today</span>
                    </div>
                </div>
            </div>

            <!-- Información de la Empresa Card -->
            <div class="section-card">
                <div class="card-header">
                    <h2 class="card-title">Información de la Empresa</h2>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <!-- Item 1 -->
                    <div class="info-item">
                        <div class="info-main">
                            <div class="info-icon-box">
                                <span class="app-icon">fingerprint</span>
                            </div>
                            <div>
                                <p class="info-label">RUT / Identificación Fiscal</p>
                                <p class="info-value">900.123.456-7</p>
                            </div>
                        </div>
                        <button class="btn-small">Copiar</button>
                    </div>
                    <!-- Item 2 -->
                    <div class="info-item">
                        <div class="info-main">
                            <div class="info-icon-box">
                                <span class="app-icon">person</span>
                            </div>
                            <div>
                                <p class="info-label">Contacto Principal</p>
                                <p class="info-value">
                                    <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?>
                                </p>
                            </div>
                        </div>
                        <button class="btn-small">Llamar</button>
                    </div>
                </div>
            </div>

            <!-- Sucursales y Logística Card -->
            <div class="section-card">
                <div class="card-header">
                    <h2 class="card-title">Sucursales y Logística</h2>
                    <span class="role-badge"
                        style="background-color: rgba(242, 204, 13, 0.1); color: var(--color-primary);">
                        <?php echo $total_sucursales; ?>
                        Activas
                    </span>
                </div>
                <!-- Horizontal Scroll for Branches -->
                <div class="scroll-container">
                    <?php foreach ($sucursales as $sucursal): ?>
                        <div class="branch-card">
                            <div class="branch-header">
                                <span class="app-icon" style="color: var(--color-primary);">store</span>
                                <span class="branch-badge">PRINCIPAL</span>
                            </div>
                            <p class="branch-name">
                                <?php echo $sucursal['nombre_sucursal']; ?>
                            </p>
                            <p class="branch-address">
                                <?php echo $sucursal['direccion']; ?>
                            </p>
                            <div class="branch-footer">
                                <span class="branch-hours">
                                    <?php echo $sucursal['inicio_entregas'] . ' - ' . $sucursal['fin_entregas']; ?>
                                </span>
                                <span class="app-icon"
                                    style="font-size: 0.875rem; color: #9ca3af; cursor: pointer;">map</span>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div style="padding: 1rem; padding-top: 0;">
                    <button class="btn-dashed" id="btn-add-sucursal" data-id="<?php echo $cliente['id_cliente']; ?>">
                        <span class="app-icon" style="margin-right: 0.5rem;">add_circle</span>
                        Añadir Sucursal
                    </button>
                </div>
            </div>

            <!-- Panel de Facturación Card -->
            <!-- <div class="section-card" style="margin-bottom: 2.5rem;">
                <div class="card-header">
                    <h2 class="card-title">Panel de Facturación</h2>
                </div>
                <div class="billing-content">
                    <div class="billing-main">
                        <div class="billing-info">
                            <div class="billing-header">
                                <p class="stat-label">Saldo Pendiente</p>
                                <p class="warn-text">Vencido en 3 días</p>
                            </div>
                            <p class="billing-amount">$4,250.00 <span
                                    style="font-size: 0.875rem; font-weight: 400; color: #9ca3af;">MXN</span></p>
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                            <p style="font-size: 0.625rem; color: #9ca3af; margin-top: 0.5rem; font-weight: 500;">
                                USO DE CRÉDITO: $4,250 de $15,000
                            </p>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem; justify-content: center;">
                            <button class="btn-edit-profile" style="min-width: 180px; height: 2.5rem;">
                                <span class="app-icon" style="margin-right: 0.5rem;">receipt_long</span>
                                Estado de Cuenta
                            </button>
                            <button class="btn-small"
                                style="min-width: 180px; height: 2.5rem; display: flex; align-items: center; justify-content: center;">
                                <span class="app-icon" style="margin-right: 0.5rem;">download</span>
                                Última Factura
                            </button>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Panel de Facturación Card -->
            <div class="section-card" style="margin-bottom: 2.5rem;">
                <div class="card-header">
                    <h2 class="card-title">Panel de Cuenta</h2>
                </div>
                <div class="billing-content">
                    <div class="billing-main">
                        <div class="billing-info">
                            <div class="billing-header">
                                <p class="stat-label">Saldo Pendiente</p>
                                <p class="warn-text">Vencido en 3 días</p>
                            </div>
                            <p class="billing-amount">$4,250.00 <span
                                    style="font-size: 0.875rem; font-weight: 400; color: #9ca3af;">MXN</span></p>
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                            <p style="font-size: 0.625rem; color: #9ca3af; margin-top: 0.5rem; font-weight: 500;">
                                USO DE CRÉDITO: $4,250 de $15,000
                            </p>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem; justify-content: center;">
                            <button class="btn-edit-profile" id="btn-logout"
                                data-id="<?php echo $cliente['usuario']; ?>" style="min-width: 180px; height: 2.5rem;">
                                <span class="app-icon" style="margin-right: 0.5rem;">logout</span>
                                Cerrar Sesión
                            </button>
                            <button class="btn-small"
                                style="min-width: 180px; height: 2.5rem; display: flex; align-items: center; justify-content: center;">
                                <span class="app-icon" id="btn-delete" data-id="<?php echo $cliente['id_cliente']; ?>"
                                    style="margin-right: 0.5rem;">block</span>
                                Desactivar Usuario
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Bottom Navigation Bar -->
        <!-- <div class="bottom-nav">
        <a href="../index.php" class="nav-item">
            <span class="app-icon">home</span>
            <span class="nav-label">INICIO</span>
        </a>
        <div class="nav-item">
            <span class="app-icon">inventory_2</span>
            <span class="nav-label">PRODUCTOS</span>
        </div>
        <div class="nav-item active">
            <span class="app-icon" style="font-variation-settings: 'FILL' 1;">account_circle</span>
            <span class="nav-label">PERFIL</span>
        </div>
        <div class="nav-item">
            <span class="app-icon">support_agent</span>
            <span class="nav-label">SOPORTE</span>
        </div>
    </div> -->




    </div>
    <?php require_once 'registrar_sucursal.php'; ?>
    <?php require_once 'editar_form.php'; ?>
    <script src="crear_sucursal.js"></script>
    <script src="modal_editar.js"></script>
    <script src="../../auth/logout.js"></script>
    <script src="../../auth/soft_delete.js"></script>

</body>

</html>