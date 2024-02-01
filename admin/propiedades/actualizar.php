<?php // -> EP 326

use App\Propiedad;

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
$errores = [];

// *Ejecutar el código después de que el usuario envia el formulario* //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $propiedad->sincronizar($_POST);
    debuguear($propiedad);
    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }
    if (!$precio) {
        $errores[] = "El precio es obligatorio";
    }
    if (strlen($descripcion) < 50) {
        $errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "El número de habitaciones es obligatorio";
    }
    if (!$wc) {
        $errores[] = "El número de baños es obligatorio";
    }
    if (!$estacionamiento) {
        $errores[] = "El número de estacionamientos es obligatorio";
    }
    if (!$vendedor) {
        $errores[] = "Elige un vendedor";
    }
    //Validar por tamaño (1mb máximo)
    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

    //Revisar que el arreglo de errores esté vacío
    if (empty($errores)) {
        // ** Subida de archivos **//
        // Crear carpeta
        $carpetaImagenes = '../../imagenes';
        if (!is_dir($carpetaImagenes)) { //-> Si no existe la carpeta la creamos
            mkdir($carpetaImagenes);
        }
        // *Validar si existe una imagen previa*//
        if ($imagen['name']) {
            unlink($carpetaImagenes . $propiedad['imagen']); //-> Eliminamos la imagen anterior

            // *Generar un nombre único para cada imagen*//
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; //Capitulo 322

            //* Subir la imagen *//
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . "/$nombreImagen"); //-> Movemos la imagen a la carpeta imagenes
        } else {
            $nombreImagen = $propiedad['imagen'];
        }

        // *Insertar en la base de datos* //
        $query = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen', descripcion = '$descripcion', 
        habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedores_id = $vendedor WHERE id = $id ";

        // *Almacenamos en la Base de datos*//
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
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