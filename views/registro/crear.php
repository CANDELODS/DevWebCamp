<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">Elige Tu Plan</p>

    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">Pase Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual A Devwebcamp</li>
            </ul>
            <p class="paquete__precio">0 COP</p>

            <form action="/finalizar-registro/gratis" method="post">
                <input type="submit" class="paquetes__submit" value="Inscripción Gratis">
            </form>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase Presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Presencial A Devwebcamp</li>
                <li class="paquete__elemento">Pase Por 2 Dias</li>
                <li class="paquete__elemento">Acceso A Talleres Y Conferencias</li>
                <li class="paquete__elemento">Acceso A Grabaciones</li>
                <li class="paquete__elemento">Camisa Del Evento</li>
                <li class="paquete__elemento">Comida Y Bebida</li>
            </ul>
            <p class="paquete__precio">800.000 COP</p>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase Virutal</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual A Devwebcamp</li>
                <li class="paquete__elemento">Pase Por 2 Dias</li>
                <li class="paquete__elemento">Acceso A Talleres Y Conferencias</li>
                <li class="paquete__elemento">Acceso A Grabaciones</li>
            </ul>
            <p class="paquete__precio">200.000 COP</p>
    </div>
</main>