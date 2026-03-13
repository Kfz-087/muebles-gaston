<?php

require_once __DIR__ . "/../../config/conexion.php";
$conn = conectar();

$id_pedido = $_POST['id_pedido'];
$status = $_POST['status'];
$valid_statuses = ['pendiente', 'en_preparacion', 'en_camino', 'entregado', 'cancelado'];

if (!in_array($status, $valid_statuses)) {
    echo "Estado inválido";
} else {
    $sql = "UPDATE pedidos SET estado = :status";
    $params = ['status' => $status, 'id_pedido' => $id_pedido];

    if ($status === 'entregado') {
        $sql .= ", fecha_entrega = CURRENT_TIMESTAMP";
    }

    $sql .= " WHERE id_pedido = :id_pedido";

    $result = $conn->prepare($sql);
    $result->execute($params);

    if ($result) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar el estado del pedido";
    }
}




?>