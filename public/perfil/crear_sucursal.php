<?php

require_once "../../config/conexion.php";
$conn = conectar();

$id = $_POST['id_cliente'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$localidad = $_POST['localidad'];
$horario_apertura = $_POST['horario_apertura'];
$horario_cierre = $_POST['horario_cierre'];

$sql = "INSERT INTO sucursales_clientes (
    id_cliente, 
    nombre_sucursal, 
    direccion, 
    localidad, 
    inicio_entregas, 
    fin_entregas
) VALUES (
    :id_cliente, 
    :nombre, 
    :direccion, 
    :localidad, 
    :horario_apertura, 
    :horario_cierre
)";
$consulta = $conn->prepare($sql);
$consulta->execute([
    ':id_cliente' => $id,
    ':nombre' => $nombre,
    ':direccion' => $direccion,
    ':localidad' => $localidad,
    ':horario_apertura' => $horario_apertura,
    ':horario_cierre' => $horario_cierre
]);

header("Location: index.php");

?>