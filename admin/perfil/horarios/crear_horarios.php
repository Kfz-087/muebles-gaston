<?php
require_once "../../../config/conexion.php";
$conn = conectar();
$dia = $_POST['dia_semana'];
$dias = [0 => "Lunes", 1 => "Martes", 2 => "Miercoles", 3 => "Jueves", 4 => "Viernes", 5 => "Sabado", 6 => "Domingo"];
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = $_POST['hora_fin'];
$abierto = $_POST['abierto'];
$opcionesabierto = [0 => "No", 1 => "Sí"];

$dia_semana = $dias[$dia];
$abierto = $opcionesabierto[$abierto];

if ($abierto == "No") {
    $sql = "INSERT INTO horarios (dia_semana, abierto) VALUES (?, ?)";
    $consulta = $conn->prepare($sql);
    $resultado = $consulta->execute([$dia_semana, $abierto]);
} else {
    if (empty($dia_semana) || empty($hora_inicio) || empty($hora_fin)) {
        echo json_encode(["error" => "Debe seleccionar un dia de la semana y una hora de inicio y fin"]);
        exit;
    } else {
        try {
            $sql = "INSERT INTO horarios (dia_semana, hora_apertura, hora_cierre, abierto) VALUES (?, ?, ?, ?)";
            $consulta = $conn->prepare($sql);
            $resultado = $consulta->execute([$dia_semana, $hora_inicio, $hora_fin, $abierto]);
            if ($resultado) {
                echo json_encode(["success" => "Horario creado exitosamente"]);
            } else {
                echo json_encode(["error" => "Error al crear el horario . $error"]);
            }
        } catch (Exception $e) {
            echo json_encode(["error" => "Error al crear el horario . $e"]);
        }
    }

}



?>