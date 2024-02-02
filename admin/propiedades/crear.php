<?php // -> EP 310
//Protegemos el archivo para que no se pueda acceder desde la url
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();


$propiedad = new Propiedad;

//Consulta para obtener todos los vendedores
$vendedores = Vendedor::all();


//Arreglo con mensajes de errores desde la clase propiedad
$errores = Propiedad::getErrores();

//Ejecutar el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $propiedad = new Propiedad($_POST['propiedad']); //-> Instanciamos la clase Propiedad


    //* Generar un nombre único para cada imagen *//
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; //Capitulo 322

    //Realiza un rezise a la imagen con intervention
    if ($_FILES['propiedad']['tmp_name']['imagen']) { //-> Si existe la imagen
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen); //-> Seteamos el nombre de la imagen
    }


    $errores = $propiedad->validar(); //-> Llamamos al método validar


    //Revisar que el arreglo de errores esté vacío
    if (empty($errores)) {

        //Crear la carpeta para subir imagenes si no existe.
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        //Guarda la imagen en el servidor/carpeta
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        //Guarda en la base de datos
        $propiedad->guardar(); //-> Llamamos al método guardar
    }
}
//->
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error) : ?> <!--Mostramos los errores -->
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?> <!--Reutilizamos codigo-->
        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplate('footer');
?>