<main class="agenda">
    <h2 class="agenda__heading"><?php echo $titulo; ?></h2>
    <p class="agenda__descripcion">Talleres Y Conferencias Dictados Por Expertos En Desarrollo Web</p>

    <div class="eventos">
        <h3 class="eventos__heading">&lt;Conferencias /></h3>
        <p class="eventos__fecha">Viernes 29 De Agosto</p>

        <!-- Swiper Para El Slider -->
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper"> <!-- Esta CLase Es Requerida Por Swiper -->
            <?php foreach($eventos['conferencias_v'] as $evento){ ?>
                <?php include __DIR__ . '../../templates/evento.php'; ?>
            <?php } ?>
            </div> <!--.swiper-wrapper-->
            <!--Es De La Librería De Swiper, Pone Las Flechitas Para Mover Los Slides-->
            <di class="swiper-button-next"></di>
            <di class="swiper-button-prev"></di>
        </div>

        <p class="eventos__fecha">Sábado 30 De Agosto</p>
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper"> <!-- Esta CLase Es Requerida Por Swiper -->
            <?php foreach($eventos['conferencias_s'] as $evento){ ?>
                <?php include __DIR__ . '../../templates/evento.php'; ?>
            <?php } ?>
            </div> <!--.swiper-wrapper-->
            <!--Es De La Librería De Swiper, Pone Las Flechitas Para Mover Los Slides-->
            <di class="swiper-button-next"></di>
            <di class="swiper-button-prev"></di>
        </div>

    </div> <!--.eventos-->

    <div class="eventos eventos--workshops">
        <h3 class="eventos__heading">&lt;Workshops /></h3>
        <p class="eventos__fecha">Viernes 29 De Agosto</p>

        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper"> <!-- Esta CLase Es Requerida Por Swiper -->
            <?php foreach($eventos['workshops_v'] as $evento){ ?>
                <?php include __DIR__ . '../../templates/evento.php'; ?>
            <?php } ?>
            </div> <!--.swiper-wrapper-->
            <!--Es De La Librería De Swiper, Pone Las Flechitas Para Mover Los Slides-->
            <di class="swiper-button-next"></di>
            <di class="swiper-button-prev"></di>
        </div>

        <p class="eventos__fecha">Sábado 30 De Agosto</p>

        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper"> <!-- Esta CLase Es Requerida Por Swiper -->
            <?php foreach($eventos['workshops_s'] as $evento){ ?>
                <?php include __DIR__ . '../../templates/evento.php'; ?>
            <?php } ?>
            </div> <!--.swiper-wrapper-->
            <!--Es De La Librería De Swiper, Pone Las Flechitas Para Mover Los Slides-->
            <di class="swiper-button-next"></di>
            <di class="swiper-button-prev"></di>
        </div>

    </div> <!--.eventos-->
</main>