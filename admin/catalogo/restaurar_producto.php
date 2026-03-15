<?php

require_once '../../config/conexion.php';
$conn = conectar();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $data = json_decode(file_get_contents('php://input'));
    $id_producto = isset($data->id_producto) ? $data->id_producto : null;

    if (!$id_producto) {
        echo json_encode(array("status" => "error", "message" => "ID de producto no proporcionado."));
        exit;
    }

    try {
        $query = "UPDATE productos SET activo = '1' WHERE id_producto = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$id_producto]);

        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(array("status" => "success", "message" => "Producto restaurado correctamente."));
        } else {
            echo json_encode(array("status" => "error", "message" => "No se pudo encontrar el producto o ya fue restaurado."));
        }
    } catch (Exception $e) {
        echo json_encode(array("status" => "error", "message" => "Error al restaurar el producto: " . $e->getMessage()));
    }
}

?>