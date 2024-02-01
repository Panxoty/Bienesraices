<?php
require 'includes/app.php';

incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Conoce sobre Nosotros</h1>
    <div class="contenido-nosotros">
        <div class="imagen">
            <picture>
                <source srcset="build/img/nosotros.webp" type="image/webp">
                <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
            </picture>
        </div>
        <div class="texto-nosotros">
            <blockquote>25 Años de Experiencia</blockquote>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore exercitationem corporis dolores repudiandae! Veniam ea magnam minima, necessitatibus molestias, quod pariatur architecto nostrum odio commodi reprehenderit laborum earum a voluptas. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos dicta voluptatem ipsam nihil, quo rerum consectetur cum quisquam possimus. Facere eligendi saepe temporibus, aliquam at fuga ullam dolorum sint nihil.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit dignissimos nemo ducimus quisquam corrupti sed, ratione neque provident quibusdam modi minus repudiandae ipsam ea eaque eveniet officia, accusantium explicabo unde.
            </p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium officiis odio ea omnis excepturi similique repellat, fuga cupiditate possimus, consequatur vitae eum eaque maxime commodi placeat dolorem, magnam qui quas! Lorem ipsum dolor </p>
        </div>
</main>
<section class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>
    <div class="iconos-nosotros">
        <div class="icono">
            <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
            <h3>Seguridad</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, consectetur illo porro eaque dolor ex expedita consequatur accusamus debitis eos dolorem ullam est dolores provident. Necessitatibus nobis vero saepe minus!</p>
        </div><!--.icono -->
        <div class="icono">
            <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
            <h3>Precio</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, consectetur illo porro eaque dolor ex expedita consequatur accusamus debitis eos dolorem ullam est dolores provident. Necessitatibus nobis vero saepe minus!</p>
        </div><!--.icono -->
        <div class="icono">
            <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
            <h3>A tiempo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, consectetur illo porro eaque dolor ex expedita consequatur accusamus debitis eos dolorem ullam est dolores provident. Necessitatibus nobis vero saepe minus!</p>
        </div><!--.icono -->
    </div><!--.iconos-nosotros-->
</section>
<?php
incluirTemplate('footer')
?>