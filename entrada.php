<?php
require 'includes/app.php';

incluirTemplate('header');

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Guía para la decoracion de tu hogar</h1>
    <picture>
        <source srcset="build/img/destacada2.webp" type="image/webp">
        <source srcset="build/img/destacada2.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada.jpg" alt="Imagen de la propiedad">
    </picture>
    <p class="informacion-meta">Escrito el: <span>20/10/2023</span> por: <span>Admin</span></p>
    <div class="resumen-propiedad">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore exercitationem corporis dolores
            repudiandae! Veniam ea magnam minima, necessitatibus molestias, quod pariatur architecto nostrum odio
            commodi reprehenderit laborum earum a voluptas. Lorem ipsum dolor sit amet, consectetur adipisicing
            elit. Quos dicta voluptatem ipsam nihil, quo rerum consectetur cum quisquam possimus. Facere eligendi
            saepe temporibus, aliquam at fuga ullam dolorum sint nihil.
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit dignissimos nemo ducimus quisquam
            corrupti sed, ratione neque provident quibusdam modi minus repudiandae ipsam ea eaque eveniet officia,
            accusantium explicabo unde.
        </p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium officiis odio ea omnis excepturi
            similique repellat, fuga cupiditate possimus, consequatur vitae eum eaque maxime commodi placeat
            dolorem, magnam qui quas! Lorem ipsum dolor </p>
    </div>
</main>
<?php
incluirTemplate('footer')
?>