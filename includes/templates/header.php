<?php
if (!isset($_SESSION)) { //-> Si no existe la sesion
    session_start(); //-> Iniciamos la sesion
}

$auth = $_SESSION['login'] ?? null; //-> Guardamos en una variable la sesion

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <!--Preload -->
    <link rel="preload" href="/bienesraices/build/css/app.css" as="style">
    <!--Link -->
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    <header class="header <?php echo $inicio ? 'inicio' : '' ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="Logotipo Bienes Raices">
                </a>
                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="Icono responsive">
                </div>
                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="dark-mode">

                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anucios.php">Anucios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                        <?php if ($auth) { ?> <!-- Si hay sesion iniciada -->
                            <a href="/admin">Admin</a>
                            <a href="cerrar-sesion.php">Cerrar Sesión</a>
                        <?php } else { ?> <!--Si no hay sesion iniciada. -->
                            <a href="/login.php">Iniciar Sesión</a>
                        <?php } ?>
                    </nav>
                </div>
            </div><!--.barra -->
            <?php if ($inicio) { ?>
                <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>;
            <?php } ?>
        </div>
    </header>