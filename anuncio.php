<?php
require 'includes/app.php';

use App\Propiedad;

//Consultar
$propiedadId = $_GET['id'];
$propiedadId = filter_var($propiedadId, FILTER_VALIDATE_INT);
if (!$propiedadId) { // -> Si no es un numero o no hay id
    header('Location: /');
}
$propiedad = Propiedad::find($propiedadId);

//Incluimos header
incluirTemplate('header');

?>
<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad->titulo ?></h1>
    <img loading="lazy" src="imagenes/<?php echo $propiedad->imagen ?>" alt="Imagen de la propiedad">
    <div class="resumen-propiedad">
        <p class="precio">
            <?php echo $propiedad->precio ?>
        </p>
        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p>
                    <?php echo $propiedad->wc; ?>
                </p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p>
                    <?php echo $propiedad->estacionamiento; ?>
                </p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                <p>
                    <?php echo $propiedad->habitaciones; ?>
                </p>
            </li>
        </ul>
        <p>
            <?php echo $propiedad->descripcion ?>
        </p>
    </div>
</main>
<?php
incluirTemplate('footer')
?>