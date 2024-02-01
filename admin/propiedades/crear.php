<?php // -> EP 310
//Protegemos el archivo para que no se pueda acceder desde la url
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();

//Conexión a la base de datos
$db = conectarDB();

$propiedad = new Propiedad;

//Consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores desde la clase propiedad
$errores = Propiedad::getErrores();

//Ejecutar el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $propiedad = new Propiedad($_POST); //-> Instanciamos la clase Propiedad


    //* Generar un nombre único para cada imagen *//
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; //Capitulo 322

    //Realiza un rezise a la imagen con intervention
    if ($_FILES['imagen']['tmp_name']) { //-> Si existe la imagen
        $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
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
        $resultado = $propiedad->guardar(); //-> Llamamos al método guardar

        if ($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
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
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>
        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplate('footer');
?>