<?php
require_once __DIR__ . '/../../config/conexion.php';
$conn = conectar();

$id = $_GET['id_producto'];
$consulta = $conn->prepare("SELECT * FROM productos WHERE id_producto=:id_producto");
$consulta->execute([
    ':id_producto' => $id
]);
$producto = $consulta->fetch(PDO::FETCH_ASSOC);

echo json_encode($producto);
?>