<?php
// We can't easily use file_get_contents on a protected page, 
// but we can check if the variables are set before the loop.
require_once __DIR__ . '/config/conexion.php';
$conn = conectar();
$sql = "SELECT p.* FROM productos p WHERE p.activo=1 LIMIT 1";
$stmt = $conn->query($sql);
$prod = $stmt->fetch(PDO::FETCH_ASSOC);
echo "Producto: " . $prod['nombre'] . "\n";
echo "Escaped: " . htmlspecialchars($prod['nombre']) . "\n";
