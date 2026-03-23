<?php

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== '1') {
    echo json_encode(array("status" => "error", "message" => "No autorizado"));
    exit;
}

require_once '../../../config/conexion.php';
$conn = conectar();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $data = json_decode(file_get_contents('php://input'));
    $id_multimedia = isset($data->id_multimedia) ? $data->id_multimedia : null;

    if (!$id_multimedia) {
        echo json_encode(array("status" => "error", "message" => "ID de multimedia no proporcionado."));
        exit;
    }

    try {
        $query = "UPDATE multimedia SET activo = '0' WHERE id_multimedia = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$id_multimedia]);

        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(array("status" => "success", "message" => "Archivo multimedia eliminado correctamente."));
        } else {
            echo json_encode(array("status" => "error", "message" => "No se pudo encontrar el archivo o ya fue eliminado."));
        }
    } catch (Exception $e) {
        echo json_encode(array("status" => "error", "message" => "Error al eliminar el archivo: " . $e->getMessage()));
    }
}

?>