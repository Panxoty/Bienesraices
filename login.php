<?php
//Conexion a la base de datos
require 'includes/app.php';
$db = conectarDB();

//Autenticar el usuarios
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    //Si no hay email
    if (!$email) {
        $errores[] = "El email es obligatorio o no es válido";
    }
    if (!$password) {
        $errores[] = "El password es obligatorio o no es válido";
    }
    if (empty($errores)) { //->  Si no hay errores autenticamos el usuario.
        //Revisar si el usuario existe
        $query = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($db, $query);

        if ($resultado->num_rows) { //->  Si hay resultado en la consulta.
            //Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            //Se verifica si el password es correcto 
            $auth = password_verify($password, $usuario['password']);
            if ($auth) { //-> Si la pass es correcta:
                //Iniciar la sesion
                session_start();  //-> Mantiene informacion del usuario.
                //Llenar el arreglo de la sesion
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;

                //Redireccionar al usuario
                header('Location: /admin');
            } else {
                $errores[] = "El password es incorrecto";
            }
        } else {
            $errores[] = "El usuario no existe";
        }
    }
}

//Incluimos el header
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Iniciar sesión</h1>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form class="formulario" method="POST">
        <fieldset>
            <legend>Email y Password</legend>
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email">

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu Password" id="password">
        </fieldset>
        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplate('footer');
?>