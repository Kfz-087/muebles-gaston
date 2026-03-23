<?php

require_once __DIR__ . '/../../config/conexion.php';
$conn = conectar();

$id = $_POST['id_producto'];
$nombre = $_POST['nombre'];
// $peso = $_POST['peso'];
// $vencimiento = $_POST['vencimiento'];
$descripcion = $_POST['descripcion'];
// $precio = $_POST['precio'];
// $stock = $_POST['stock'];
$categoria = $_POST['categoria'];
$ruta = $_POST['ruta'] ?? null;
$color_tono = $_POST['color_tono'] ?? null;
$tipo_diseno = $_POST['tipo_diseno'] ?? null;
$superficie_acabado = $_POST['superficie_acabado'] ?? null;

// Handle image upload if a new file is provided
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombre_imagen = $_FILES['imagen']['name'];
    // Absolute path on server to save the file
    $target_dir = __DIR__ . '/../../assets/productos/';

    // Create directory if it doesn't exist (safety check)
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $ruta_archivo_servidor = $target_dir . basename($nombre_imagen);

    // Move the uploaded file
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_archivo_servidor)) {
        // Path to store in DB (relative to web root or as expected by frontend)
        // Assuming frontend expects "/distribuidora-frami/assets/productos/..." or similar
        // Based on previous code: "/assets/productos/" . $nombre_imagen
        // But user code had: $ruta_imagen = "/assets/productos/" . $nombre_imagen;
        $ruta_db = "/muebles-gaston/assets/productos/" . $nombre_imagen;

        $sql = "UPDATE productos SET nombre=:nombre, descripcion=:descripcion, id_categoria=:categoria, ruta=:ruta, color_tono=:color_tono, tipo_diseno=:tipo_diseno, superficie_acabado=:superficie_acabado WHERE id_producto=:id";
        $params = [
            ':nombre' => $nombre,
            // ':peso' => $peso,
            // ':vencimiento' => $vencimiento,
            ':descripcion' => $descripcion,
            // ':precio' => $precio,
            // ':stock' => $stock,
            ':categoria' => $categoria,
            ':ruta' => $ruta_db,
            ':color_tono' => $color_tono,
            ':tipo_diseno' => $tipo_diseno,
            ':superficie_acabado' => $superficie_acabado,
            ':id' => $id
        ];
    } else {
        echo "Error al subir la imagen.";
        exit;
    }

} else {
    // Update without changing the image
    $sql = "UPDATE productos SET nombre=:nombre, descripcion=:descripcion, id_categoria=:categoria, color_tono=:color_tono, tipo_diseno=:tipo_diseno, superficie_acabado=:superficie_acabado WHERE id_producto=:id";
    $params = [
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        // ':precio' => $precio,
        // ':stock' => $stock,
        ':categoria' => $categoria,
        ':color_tono' => $color_tono,
        ':tipo_diseno' => $tipo_diseno,
        ':superficie_acabado' => $superficie_acabado,
        ':id' => $id
    ];
}

$stmt = $conn->prepare($sql);

if ($stmt->execute($params)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error al actualizar el producto.";
}
?>