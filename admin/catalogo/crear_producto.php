<?php

require_once __DIR__ . '/../../config/conexion.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$nombre = $_POST['nombre'] ?? '';
// $peso = $_POST['peso'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
// $precio = $_POST['precio'] ?? '';
// $vencimiento = $_POST['vencimiento'] ?? '';
// $stock = $_POST['stock'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$imagen = $_POST['imagen'] ?? '';
$color_tono = $_POST['color_tono'] ?? null;
$tipo_diseno = $_POST['tipo_diseno'] ?? null;
$superficie_acabado = $_POST['superficie_acabado'] ?? null;

// Basic validation
if (empty($nombre) || empty($categoria)) {
    die("Error: Faltan datos obligatorios (Nombre o Categoría).");
}

$ruta_base_datos = ""; // Default empty path

// Handle image upload if present
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombre_imagen = time() . "_" . $_FILES['imagen']['name'];
    $directorio_destino = "../../assets/productos/";

    // Ensure directory exists - FIXED: mkdir($path, $mode, $recursive)
    if (!is_dir($directorio_destino)) {
        if (!mkdir($directorio_destino, 0777, true)) {
            die("Error: No se pudo crear el directorio de destino.");
        }
    }

    $ruta_fisica = $directorio_destino . $nombre_imagen;
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_fisica)) {
        // This is the path stored in DB, usually relative to web root or a fixed assets path
        $ruta_base_datos = "../../assets/productos/" . $nombre_imagen;
    } else {
        die("Error: No se pudo mover el archivo subido.");
    }
}

try {
    $conn = conectar();
    $consulta = $conn->prepare("INSERT INTO productos (nombre, descripcion, id_categoria, ruta, activo, color_tono, tipo_diseno, superficie_acabado) 
    VALUES(:nombre, :descripcion, :id_categoria, :ruta, 1, :color_tono, :tipo_diseno, :superficie_acabado)");

    $exito = $consulta->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        // ':peso' => $peso ?: null,
        // ':fecha_vencimiento' => $vencimiento ?: null,
        // ':stock' => $stock,
        ':id_categoria' => $categoria,
        ':ruta' => $ruta_base_datos,
        ':color_tono' => $color_tono,
        ':tipo_diseno' => $tipo_diseno,
        ':superficie_acabado' => $superficie_acabado
    ]);

    if ($exito) {
        header("Location: index.php");
        exit();
    } else {
        die("Error: La consulta no se ejecutó correctamente.");
    }
} catch (PDOException $e) {
    if ($e->getCode() == '23000') {
        die("Error de Integridad: La categoría (" . htmlspecialchars($categoria) . ") podría no existir. Detalles: " . $e->getMessage());
    } else {
        die("Error de Base de Datos: " . $e->getMessage());
    }
}