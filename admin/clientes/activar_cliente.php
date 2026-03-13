<?php
require_once '../../config/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = isset($_POST['id_cliente']) ? (int) $_POST['id_cliente'] : 0;
    $activo = isset($_POST['activo']) ? (int) $_POST['activo'] : 0;

    if ($id_cliente > 0) {
        try {
            $conn = conectar();
            $sql = "UPDATE clientes SET activo = :activo WHERE id_cliente = :id_cliente";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':activo', $activo, PDO::PARAM_INT);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID de cliente no válido']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>