<?php
require '../includes/app.php';
estaAutenticado();

use App\Propiedad;

//Implementar metodo para obtener todas las propiedades.
$propiedades = Propiedad::all();

//Asignamos el resultado de la direccion Line 92 de crear.php
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id) {
        //Eliminar el archivo
        $query = "SELECT imagen FROM propiedades WHERE id = $id";
        $resultado = mysqli_query($db, $query);
        $propiedad = mysqli_fetch_assoc($resultado);
        unlink('../imagenes/' . $propiedad['imagen']);

        //Eliminar la propiedad
        $query = "DELETE FROM propiedades WHERE id = $id";
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            header('Location: /admin?resultado=3');
        }
    }
}
//Incluimos el header de templates
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php if ($resultado == 1) : ?>
        <p class="alerta exito">Propiedad Creada Correctamente</p>
    <?php elseif ($resultado == 2) : ?>
        <p class="alerta exito">Propiedad Actualizado Correctamente</p>
    <?php elseif ($resultado == 3) : ?>
        <p class="alerta exito">Propiedad Eliminada Correctamente</p>
    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr> <!-- Titulos columnas -->
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody> <!-- Mostrar los resultados -->
            <?php foreach ($propiedades as $propiedad) : ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo; ?> </td>
                    <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"></td>
                    <td> $<?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <!--Ver EP 326 -->
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php
//Cerramos la conexion con la bd
mysqli_close($db);
incluirTemplate('footer');
?>