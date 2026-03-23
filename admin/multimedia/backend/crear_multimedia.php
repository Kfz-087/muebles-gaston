<?php

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== '1') {
    die("No autorizado");
}

require_once __DIR__ . '/../../../config/conexion.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$nombre = $_POST['nombre'] ?? '';
$duracion = $_POST['duracion'] ?? null;
// Si viene vacío en el form, lo pasamos a null para la BD si es necesario

$id_formato = $_POST['id_formato'] ?? '';
$ruta = $_FILES['ruta'] ?? null;

// Basic validation
if (empty($nombre) || empty($id_formato)) {
    die("Error: Faltan datos obligatorios (Nombre, Formato).");
}

$ruta_base_datos = ""; // Default empty path

// Handle image/video upload if present
if (isset($_FILES['ruta']) && $_FILES['ruta']['error'] === UPLOAD_ERR_OK) {
    $nombre_archivo = time() . "_" . $_FILES['ruta']['name'];
    $directorio_destino = "../../../assets/multimedia/";

    if (!is_dir($directorio_destino)) {
        if (!mkdir($directorio_destino, 0777, true)) {
            die("Error: No se pudo crear el directorio de destino.");
        }
    }

    $ruta_fisica = $directorio_destino . $nombre_archivo;
    if (move_uploaded_file($_FILES['ruta']['tmp_name'], $ruta_fisica)) {
        $ruta_base_datos = "../../assets/multimedia/" . $nombre_archivo;
    } else {
        die("Error: No se pudo mover el archivo subido.");
    }
}

try {
    $conn = conectar();
    $consulta = $conn->prepare("INSERT INTO multimedia (id_formato, nombre, ruta, duracion, fecha_subida, activo) 
    VALUES(:id_formato, :nombre, :ruta, :duracion, NOW(), 1)");

    $exito = $consulta->execute([
        ':id_formato' => $id_formato,
        ':nombre' => $nombre,
        ':ruta' => $ruta_base_datos,
        ':duracion' => $duracion !== '' ? $duracion : null
    ]);

    if ($exito) {
        header("Location: ../index.php");
        exit();
    } else {
        die("Error: La consulta no se ejecutó correctamente.");
    }
} catch (PDOException $e) {
    die("Error de Base de Datos: " . $e->getMessage());
}