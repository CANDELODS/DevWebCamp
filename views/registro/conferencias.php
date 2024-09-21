<h2 class="pagina__heading"><?php echo $titulo; ?></h2>
<p class="pagina__descripcion">Elige Hasta 5 Eventos Para Asistir De Forma Presencial
</p>
<div class="eventos-registro">
    <main class="eventos-registro__listado">
        <h3 class="eventos-registro__heading--conferencias">&lt;Conferencias /></h3>
        <p class="eventos-registro__fecha">Viernes 29 De Agosto</p>

        <div class="eventos-registro__grid">
            <?php foreach ($eventos['conferencias_v'] as $evento) { ?>
                <?php include __DIR__ . '/evento.php'; ?>
            <?php } ?>
        </div>

        <p class="eventos-registro__fecha">Sabado 30 De Agosto</p>
        <div class="eventos-registro__grid">
            <?php foreach ($eventos['conferencias_s'] as $evento) { ?>
                <?php include __DIR__ . '/evento.php'; ?>
            <?php } ?>
        </div>

        <h3 class="eventos-registro__heading--workshops">&lt;Workshops /></h3>
        <p class="eventos-registro__fecha">Viernes 29 De Agosto</p>

        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach ($eventos['workshops_v'] as $evento) { ?>
                <?php include __DIR__ . '/evento.php'; ?>
            <?php } ?>
        </div>

        <p class="eventos-registro__fecha">Sabado 30 De Agosto</p>
        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach ($eventos['workshops_s'] as $evento) { ?>
                <?php include __DIR__ . '/evento.php'; ?>
            <?php } ?>
        </div>
    </main>

    <aside class="registro">
        <h2 class="registro__heading">Tu Registro</h2>
        <div class="registro__resumen" id="registro-resumen"></div>
        <div class="registro__regalo">
            <label for="regalo" class="registro__label">Selecciona Un Regalo</label>
            <!--No Usamos Name En El Select Por Que Mandaremos Los Damos Con Fetch API-->
            <select id="regalo" class="registro__select">
                <option value="">-- Selecciona Tu Regalo --</option>
                <?php foreach($regalos as $regalo){ ?>
                    <option value="<?php echo $regalo->id; ?>"><?php echo $regalo->nombre; ?></option>
                <?php }; ?>
            </select> 
        </div>

        <form class="registro" id="formulario">
            <div class="formulario__campo">
                <input type="submit" class="formulario__submit formulario__submit--full" value="Registrarme">
            </div>
        </form>
    </aside>
</div>