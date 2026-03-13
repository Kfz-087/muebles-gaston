<?php
session_start();

require_once '../config/conexion.php';
$conn = conectar();

$data = json_decode(file_get_contents('php://input'), true);
$usuario = $data['usuario'] ?? '';

if ($usuario == $_SESSION['usuario']) {
    session_destroy();
    echo json_encode([
        "status" => "success",
        "message" => "Logout Exitoso"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No hay sesión activa"
    ]);
}



?>