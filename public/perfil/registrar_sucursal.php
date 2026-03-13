<div class="modal-content" style="display:none">
    <form action="crear_sucursal.php" class="modal" method="post" id="modal-sucursal">
        <div style="display: flex; justify-content: flex-end;">
            <span class="close" style="color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        </div>
        <h1> Registrar Sucursal </h1>

        <input type="hidden" value="<?php echo $cliente['id_cliente']; ?>" name="id_cliente">

        <label for="nombre" style="margin-bottom:25px;">Nombre</label>
        <input type="text" class='modificar' name="nombre" id="nombre">
        <label for="direccion" style="margin-bottom:25px;">Direccion</label>
        <input type="text" class='modificar' name="direccion" id="direccion">
        <label for="localidad" style="margin-bottom:25px;">Localidad</label>
        <input type="text" class='modificar' name="localidad" id="localidad">

        <label for="horario">Inicio de Entregas</label>
        <input type="time" class='modificar' name="horario_apertura" id="horario_apertura">
        <label for="horario">Fin de Entregas</label>
        <input type="time" class='modificar' name="horario_cierre" id="horario_cierre">
        <input type="submit" value="Registrar">
    </form>
</div>