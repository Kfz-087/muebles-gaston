<?php

session_start();
$data = json_decode(file_get_contents("php://input"), true);

require_once '../config/conexion.php';
$conn = conectar();

$id_cliente = $data['id_cliente'];

$sql = "UPDATE clientes SET activo = 0 WHERE id_cliente = :id_cliente";
$registro = $conn->prepare($sql);
$registro->execute([
    ':id_cliente' => $id_cliente
]);

echo json_encode([
    "status" => "success",
    "message" => "Usuario Desactivado exitosamente",
    "id_cliente" => $id_cliente
]);

?>