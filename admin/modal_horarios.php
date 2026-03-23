<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== '1') {
    die("No autorizado");
}

require_once __DIR__ . '/../config/conexion.php';

$conn = conectar();

$sql = "SELECT * FROM horarios";
$preparar = $conn->prepare($sql);
$preparar->execute();
$horarios = $preparar->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="modal" id="modal-horarios">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Horarios de Atención</h2>
            <button class="modal-close" id="modal-close-horarios">&times;</button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="hidden" name="id_horario" id="id_horario">
                <!-- <input type="text" name="dia" id="dia"> -->
                <select name="dia" id="dia">
                    <option value="">Seleccione un día</option>
                    <option value="1">Lunes</option>
                    <option value="2">Martes</option>
                    <option value="3">Miercoles</option>
                    <option value="4">Jueves</option>
                    <option value="5">Viernes</option>
                    <option value="6">Sabado</option>
                    <option value="7">Domingo</option>
                </select>
                <input type="time" name="hora_inicio" id="hora_inicio">
                <input type="time" name="hora_fin" id="hora_fin">
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
</div>