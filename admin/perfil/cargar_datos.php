<?php
require_once '../../config/conexion.php';
$conn = conectar();

if (isset($_GET['id_cliente'])) {
    $id = $_GET['id_cliente'];

    $stmt = $conn->prepare("SELECT * FROM clientes WHERE id_cliente = :id");
    $stmt->execute([':id' => $id]);

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        echo json_encode($cliente);
    } else {
        echo json_encode(["error" => "Cliente no encontrado"]);
    }
} else {
    echo json_encode(["error" => "ID no proporcionado"]);
}
?>