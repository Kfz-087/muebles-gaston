<?php

require_once __DIR__ . '/../../config/conexion.php';
$conn = conectar();

$id = $_POST['id_producto'];
$consulta = $conn->prepare("UPDATE productos SET activo=0 WHERE id_producto=:id_producto");
$consulta->execute([
    ':id_producto' => $id
]);

if ($consulta->rowCount() > 0) {
    echo json_encode([
        'success' => true,
        'message' => 'Producto eliminado correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar el producto'
    ]);
}
?>