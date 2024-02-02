<?php // -> EP 326

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';
estaAutenticado();

// ** Obtener el id de la propiedad **//
$id = $_GET['id']; //-> Obtenemos el id en la url de la propiedad que pasamos en la linea 51 de index.php
$id = filter_var($id, FILTER_VALIDATE_INT); //-> Validamos que sea un entero
if (!$id) { //-> Si no es un entero redireccionamos
    header('Location: /admin');
}

// * Obtener los datos de la propiedad * //
$propiedad = Propiedad::find($id);

// ** Obtener los datos de vendedores **//
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

// *Ejecutar el código después de que el usuario envia el formulario* //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Asignar los atributos
    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    //Validación
    $errores = $propiedad->validar(); //-> Llamamos al método validar

    //Asignar files hacia una variable.
    $imagen = $_FILES['imagen'];

    //^ Subida de archivos ^//
    //Generar un nombre unico para la imagen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; //Capitulo 322

    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen); //-> Seteamos el nombre de la imagen
    }

    //Revisar que el arreglo de errores esté vacío
    if (empty($errores)) {
        $propiedad->guardar(); //-> Llamamos al método guardar
    }
}
//->

incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error) : ?> <!--Mostramos los errores -->
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>
        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplate('footer');
?>