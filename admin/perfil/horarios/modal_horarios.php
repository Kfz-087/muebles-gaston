<div id="crear_horarios-modal" class="modal-horarios-overlay">
    <div class="horarios-content">
        <span class="cerrar">&times;</span>
        <form action="horarios/crear_horarios.php" method="post" id="crear_horarios_form">
            <h3 class="modal-title">Registrar Horario</h3>
            <div class="horarios-wrapper">
                <div class="form-group">
                    <label for="dia_semana">Día de la Semana</label>
                    <select name="dia_semana" id="dia_semana">
                        <option value="0">Lunes</option>
                        <option value="1">Martes</option>
                        <option value="2">Miercoles</option>
                        <option value="3">Jueves</option>
                        <option value="4">Viernes</option>
                        <option value="5">Sabado</option>
                        <option value="6">Domingo</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="hora_inicio">Hora Inicio</label>
                    <input type="time" name="hora_inicio" id="hora_inicio">
                </div>

                <div class="form-group">
                    <label for="hora_fin">Hora Fin</label>
                    <input type="time" name="hora_fin" id="hora_fin">
                </div>

                <div class="form-group">
                    <select name="abierto" id="abierto">
                        <option value=""> ¿Negocio Abierto? </option>
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-save-horario">Guardar Horario</button>
        </form>
    </div>
</div>