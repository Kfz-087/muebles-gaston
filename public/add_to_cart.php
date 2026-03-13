<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$productId = isset($input['id']) ? intval($input['id']) : 0;
$quantity = isset($input['cantidad']) ? intval($input['cantidad']) : 1;

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de producto inválido']);
    exit;
}

$conn = conectar();
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}

// Fetch product details
$stmt = $conn->prepare("SELECT id_producto, nombre, precio, ruta FROM productos WHERE id_producto = :id");
$stmt->execute([':id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
    exit;
}

// Initialize cart if not exists
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Check if product already in cart
if (isset($_SESSION['carrito'][$productId])) {
    $_SESSION['carrito'][$productId]['cantidad'] += $quantity;

    // If quantity is 0 or less, remove from cart
    if ($_SESSION['carrito'][$productId]['cantidad'] <= 0) {
        unset($_SESSION['carrito'][$productId]);
    }
} else if ($quantity > 0) {
    $_SESSION['carrito'][$productId] = [
        'id' => $product['id_producto'],
        'nombre' => $product['nombre'],
        'precio' => $product['precio'],
        'imagen' => $product['ruta'],
        'cantidad' => $quantity
    ];
}

// Calculate total items
$totalItems = 0;
foreach ($_SESSION['carrito'] as $item) {
    $totalItems += $item['cantidad'];
}

echo json_encode([
    'success' => true,
    'message' => 'Producto agregado',
    'cartCount' => $totalItems
]);
