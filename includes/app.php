<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//Conexión a la base de datos
$db = conectarDB();


//Importamos clases
use App\Propiedad;

//Pasamos la conexion a la base de datos a la clase Propiedad - EP 365.
Propiedad::setDB($db);
