<?php
require '../includes/app.php';
estaAutenticado();

use App\Propiedad;
use App\Vendedor;

//Implementar metodo para obtener todas las propiedades.
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

//debuguear($vendedores);

//Asignamos el resultado de la direccion Line 92 de crear.php
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id) {
        $tipo = $_POST['tipo'];
        if (validarTipoContenido($tipo)) {
            //Compara lo que vamos a eliminar
            if ($tipo === 'vendedor') {
                $vendedor = Vendedor::find($id);
                $vendedor->eliminar();
            } else if ($tipo === 'propiedad') {
                $propiedad = Propiedad::find($id);
                $propiedad->eliminar();
            }
        }
    }
}
//Incluimos el header de templates
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php if ($resultado == 1) : ?>
        <p class="alerta exito">Creado Correctamente</p>
    <?php elseif ($resultado == 2) : ?>
        <p class="alerta exito">Actualizado Correctamente</p>
    <?php elseif ($resultado == 3) : ?>
        <p class="alerta exito">Eliminado Correctamente</p>
    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo(a) Vendedor</a>
    <h2>Propiedades</h2>
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
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <!--Ver EP 326 -->
                        <a href="/admin/vendedores/actualizar.php?id=<?php echo $propiedad->id ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr> <!-- Titulos columnas -->
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody> <!-- Mostrar los resultados -->
            <?php foreach ($vendedores as $vendedor) : ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?> </td>
                    <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                    <td> <?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <!--Ver EP 326 -->
                        <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php
incluirTemplate('footer');
?>