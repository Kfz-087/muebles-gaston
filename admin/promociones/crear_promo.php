<?php

require_once "../../config/conexion.php";

$conn = conectar();

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio_regular = $_POST['precio_regular'];
$valor_descuento = floatval($_POST['valor_descuento']);
$precio_regular = floatval($_POST['precio_regular']);
$tipo_descuento = $_POST['tipo_descuento'];

$tipos = ["porcentaje", "monto_fijo", "2x1", "cuotas"];
if (!in_array($tipo_descuento, $tipos)) {
    die("Tipo de descuento inválido");
}

if ($tipo_descuento == "porcentaje") {
    // Ejemplo: 10% de 100 -> Descuento = 10, Precio Promo = 90
    $descuento_real = $precio_regular * ($valor_descuento / 100);
    $precio_promocional = $precio_regular - $descuento_real;
} elseif ($tipo_descuento == "monto_fijo") {
    // Ejemplo: $20 de descuento fijo -> Precio Promo = 80
    $precio_promocional = $precio_regular - $valor_descuento;
} elseif ($tipo_descuento == "2x1") {
    // Ejemplo: 2x1 significa que llevas 2 por el precio de 1, es decir, 50% de descuento por unidad
    $precio_promocional = $precio_regular / 2;
} elseif ($tipo_descuento == "cuotas") {
    // Ejemplo: 3 cuotas sin interés -> Precio Promo = 100
    $precio_promocional = $precio_regular;
}

// Asegurar que no sea negativo
if ($precio_promocional < 0)
    $precio_promocional = 0;

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$productos_ids = $_POST['producto_id']; // Esto es un array ahora

// Insertar la promoción (usamos el primer producto para la columna id_producto por compatibilidad si es necesario)
$primer_producto = !empty($productos_ids[0]) ? $productos_ids[0] : null;

$sql = "INSERT INTO promociones (nombre, descripcion, tipo_descuento, fecha_inicio, fecha_fin, activa) VALUES (:nombre, :descripcion, :tipo_descuento, :fecha_inicio, :fecha_fin, 1)";
$registro = $conn->prepare($sql);
$registro->execute([
    ':nombre' => $nombre,
    ':descripcion' => $descripcion,
    ':tipo_descuento' => $tipo_descuento,
    ':tipo_descuento' => $tipo_descuento,
    ':fecha_inicio' => $fecha_inicio,
    ':fecha_fin' => $fecha_fin,

]);

$promocion_id = $conn->lastInsertId();

// Insertar todos los productos seleccionados en la tabla de relación
$sql2 = "INSERT INTO promociones_productos (id_promocion, id_producto) VALUES (:id_promocion, :id_producto)";
$registro2 = $conn->prepare($sql2);

foreach ($productos_ids as $p_id) {
    if (!empty($p_id)) {
        $registro2->execute([
            ':id_promocion' => $promocion_id,
            ':id_producto' => $p_id
        ]);
    }
}

header("Location: ../index.php");

?>