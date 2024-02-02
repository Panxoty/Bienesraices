<?php
require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();
//Validar que sea entero
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /admin');
}
//Obtener los datos del vendedor
$vendedor = Vendedor::find($id);

//Array con mensajes de errores
$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Asignar los valores
    $args = $_POST['vendedor'];
    //Sincronizar el objeto en memoria con lo que el usuario escribio
    $vendedor->sincronizar($args);

    //Validacion
    $errores = $vendedor->validar();
    if (empty($errores)) {
        $vendedor->guardar();
    }
}
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Actualizar Vendedor(a)</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error) : ?> <!--Mostramos los errores -->
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form class="formulario" method="POST" action="/admin/vendedores/actualizar.php">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?> <!--Reutilizamos codigo-->
        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplate('footer');
?>