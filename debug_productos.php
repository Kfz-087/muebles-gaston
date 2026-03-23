<?php
require_once __DIR__ . '/config/conexion.php';
$conn = conectar();
$query = $conn->query("SELECT id_producto, nombre, ruta FROM productos LIMIT 10");
print_r($query->fetchAll(PDO::FETCH_ASSOC));
