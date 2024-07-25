<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Evento</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre Evento</label>
        <input
        type="text"
        class="formulario__input"
        name="nombre" id="nombre"
        placeholder="Nombre Evento">
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea
        class="formulario__input"
        name="descripcion" id="descripcion"
        placeholder="Descripción Evento"
        rows="8"
        ></textarea>
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Categoria O Tipo De Evento</label>
        <select class="formulario__select" name="categoria_id" id="categoria">
            <option value="">-- Seleccionar --</option>
            <?php foreach($categorias as $categoria){ ?>
                <option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Selecciona El Día</label>
        
        <div class="formulario__radio">
            <?php foreach($dias as $dia) { ?>
                <div class="">
                    <!-- strtoLower Convierte Un String A Minusculas -->
                    <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre; ?></label>

                    <input type="radio" name="dia" id="<?php echo strtolower($dia->nombre); ?>" value="<?php echo $dia->id; ?>">
                </div>
            <?php } ?>
        </div>
    </div>	

    <div id="horas" class="formulario__campo">
        <label for="" class="formulario__label">Seleccionar Hora</label>

        <ul class="horas">
                <?php foreach($horas as $hora) { ?>
                    <li class="horas__hora"><?php echo $hora->hora; ?></li>
                <?php } ?>
        </ul>
    </div>

</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Extra</legend>

    <div class="formulario__campo">
        <label for="ponentes" class="formulario__label">Ponente</label>
        <input
        type="text"
        class="formulario__input"
        id="ponentes"
        placeholder="Buscar Ponente">
    </div>

    <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Lugares Disponibles</label>
        <input
        type="number" min="1"
        class="formulario__input"
        id="disponibles"
        placeholder="Ej. 20">
    </div>
</fieldset>