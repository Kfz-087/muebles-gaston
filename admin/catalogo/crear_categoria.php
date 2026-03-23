<?php

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== '1') {
    die("No autorizado");
}

require_once __DIR__ . '/../../config/conexion.php';

$nombre = $_POST['nombre'] ?? '';


// Basic validation
if (empty($nombre)) {
    die("Error: Faltan datos obligatorios (Nombre).");
}

try {
    $conn = conectar();
    $consulta = $conn->prepare("INSERT INTO categoria (nombre) 
    VALUES(:nombre)");
    $consulta->execute([
        ':nombre' => $nombre,
    ]);

    header("Location: index.php");
} catch (PDOException $e) {
    if ($e->getCode() == '23000') { // Integrity constraint violation
        die("Error: La categoría seleccionada no es válida o no existe.");
    } else {
        die("Error al crear el producto: " . $e->getMessage());
    }
}




