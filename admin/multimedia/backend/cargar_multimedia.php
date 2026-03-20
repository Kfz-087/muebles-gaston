<?php
require_once '../../../config/conexion.php';
$conn = conectar();

if (isset($_GET['id_multimedia'])) {
    $id = intval($_GET['id_multimedia']);
    
    $stmt = $conn->prepare("
        SELECT m.*, f.tipo 
        FROM multimedia m 
        LEFT JOIN formatos f ON m.id_formato = f.id_formato 
        WHERE m.id_multimedia = ?
    ");
    $stmt->execute([$id]);
    $multimedia = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($multimedia) {
        echo json_encode($multimedia);
    } else {
        echo json_encode(["error" => "Archivo multimedia no encontrado"]);
    }
} else {
    echo json_encode(["error" => "ID no proporcionado"]);
}
?>
