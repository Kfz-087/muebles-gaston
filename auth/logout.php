<?php

session_start();

$data = json_decode(file_get_contents('php://input'), true);
$usuario = $data['usuario'] ?? '';

if (isset($_SESSION['usuario']) && $usuario == $_SESSION['usuario']) {
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