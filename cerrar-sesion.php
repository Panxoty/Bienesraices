<?php
session_start();
$_SESSION = []; //-> Se vacia el arreglo de la sesion. para cerrar sesion.
header('Location: /'); //-> Redireccionamos al index.
