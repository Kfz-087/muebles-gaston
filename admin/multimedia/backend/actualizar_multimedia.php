<?php

require_once __DIR__ . '/../../../config/conexion.php';
$conn = conectar();

$id = $_POST['id_multimedia'];
$nombre = $_POST['nombre'];
$duracion = $_POST['duracion'] ?? null;
$id_formato = $_POST['id_formato'];
$ruta = $_POST['ruta'] ?? '';

// Handle image upload if a new file is provided
if (isset($_FILES['ruta']) && $_FILES['ruta']['error'] === UPLOAD_ERR_OK) {
    $nombre_archivo = time() . "_" . $_FILES['ruta']['name'];
    // Absolute path on server to save the file
    $target_dir = __DIR__ . '/../../../assets/multimedia/';

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $ruta_archivo_servidor = $target_dir . basename($nombre_archivo);

    if (move_uploaded_file($_FILES['ruta']['tmp_name'], $ruta_archivo_servidor)) {
        $ruta_db = "../../assets/multimedia/" . $nombre_archivo;

        $sql = "UPDATE multimedia SET nombre=:nombre, duracion=:duracion, id_formato=:id_formato, ruta=:ruta WHERE id_multimedia=:id";
        $params = [
            ':nombre' => $nombre,
            ':duracion' => $duracion !== '' ? $duracion : null,
            ':id_formato' => $id_formato,
            ':ruta' => $ruta_db,
            ':id' => $id
        ];
    } else {
        echo "Error al subir el archivo multimedia.";
        exit;
    }

} else {
    // Update without changing the image/video
    $sql = "UPDATE multimedia SET nombre=:nombre, duracion=:duracion, id_formato=:id_formato WHERE id_multimedia=:id";
    $params = [
        ':nombre' => $nombre,
        ':duracion' => $duracion !== '' ? $duracion : null,
        ':id_formato' => $id_formato,
        ':id' => $id
    ];
}

$stmt = $conn->prepare($sql);

if ($stmt->execute($params)) {
    header("Location: ../index.php");
    exit();
} else {
    echo "Error al actualizar el archivo multimedia.";
}
?>