<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Evento</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre Evento</label>
        <input
        type="text"
        class="formulario__input"
        name="nombre" id="nombre"
        placeholder="Nombre Evento"
        value="<?php echo $evento->nombre;?>">
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea
        class="formulario__input"
        name="descripcion" id="descripcion"
        placeholder="Descripción Evento"
        rows="8"
        ><?php echo $evento->descripcion;?></textarea>
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Categoria O Tipo De Evento</label>
        <select class="formulario__select" name="categoria_id" id="categoria">
            <option value="">-- Seleccionar --</option>
            <?php foreach($categorias as $categoria){ ?>
                <option <?php echo ($evento->categoria_id === $categoria->id) ? 'selected' : '' ?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre ?></option>
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

        <input type="hidden" name="dia_id" value="">
    </div>	

    <div class="formulario__campo">
        <label for="" class="formulario__label">Seleccionar Hora</label>

        <ul id="horas" class="horas">
                <?php foreach($horas as $hora) { ?>
                    <li data-hora-id="<?php echo $hora->id; ?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora; ?></li>
                <?php } ?>
        </ul>

        <input type="hidden" name="hora_id" value="">
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

        <ul id="listado-ponentes" class="listado-ponentes"></ul>
        <input type="hidden" name="ponente_id" value="">
    </div>

    <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Lugares Disponibles</label>
        <input
        type="number" min="1"
        class="formulario__input"
        id="disponibles"
        name="disponibles"
        placeholder="Ej. 20"
        value="<?php echo $evento->disponibles; ?>"
        >
    </div>
</fieldset>