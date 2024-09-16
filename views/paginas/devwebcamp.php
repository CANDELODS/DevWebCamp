<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>
    <p class="devwebcamp__descripcion">Conoce La Conferencia Más Importante De Latinoamérica</p>

    <div class="devwebcamp__grid">
        <div <?php aos_animacion();?> class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img src="build/img/sobre_devwebcamp.jpg" alt="Imagen Devwebcamp" loading="lazy" width="200" heigth="300">
            </picture>
        </div>
        <div <?php aos_animacion();?> class="devwebcamp__contenido">
            <p class="devwebcamp__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Tenetur similique reprehenderit, quaerat fuga sint vero officia vitae quas.
                Fuga nihil quas quisquam iure nesciunt autem quam cum voluptatibus velit deleniti.
            </p>
            <p class="devwebcamp__texto">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Tenetur similique reprehenderit, quaerat fuga sint vero officia vitae quas.
                Fuga nihil quas quisquam iure nesciunt autem quam cum voluptatibus velit deleniti.
            </p> 
        </div>
    </div>
</main>