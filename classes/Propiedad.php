<?php

namespace App;

class Propiedad
{
    //Base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];
    //Errores
    protected static $errores = [];

    //Atributos base de datos
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    //Definir la conexión a la base de datos como static
    public static function setDB($database)
    {
        //SELF HACE REFERENCIA A LOS ATRIBUTOS STATIC DE LA CLASE
        self::$db = $database;
    }

    //Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null; //-> En caso de que no este presente el id, se le asigna un null
        $this->titulo = $args['titulo'] ?? ''; //-> En caso de que no este presente el titulo, se le asigna un string vacio
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }
    public function guardar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarDatos();
        $string = join(', ', array_keys($atributos)); //-> Convierte el array en un string


        //Insertar en la base de datos
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos)); //
        $query .= ") VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        return $resultado;
    }
    //Se encarga de iterar columnasDB
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue; //Si la columna es igual a id, se salta la iteración
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarDatos()
    {
        $atributos = $this->atributos(); //-> Se llama al método atributos
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
    //Obtener los errores
    public static function getErrores()
    {
        return self::$errores;
    }
    //Validación
    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }
        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "El número de habitaciones es obligatorio";
        }
        if (!$this->wc) {
            self::$errores[] = "El número de baños es obligatorio";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "El número de estacionamientos es obligatorio";
        }
        if (!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
        }
        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }
    //Subida de archivos
    public function setImagen($imagen)
    {
        //Asignar al atributo imagen el nombre de la imagen.
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
    //Lista todas las Propiedades
    public static function all()
    {
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    //Listar propiedad por id
    public static function find($id)
    {
        $query = "SELECT * FROM propiedades WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado); //-> Retorna el primer elemento del array
    }

    public static function consultarSQL($query)
    {
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar resultados
        $array = [];
        while ($registo = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registo); //Convertimos de array a objeto
        }
        //Liberar memoria
        $resultado->free();
        //Retornar resultados
        return $array;
    }
    protected static function crearObjeto($registo)
    {
        $objeto = new self;

        foreach ($registo as $key => $value) {
            if (property_exists($objeto, $key)) { //-> Si la propiedad existe en el objeto
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) { //-> Si la propiedad existe en el objeto
                $this->$key = $value;
            }
        }
    }
}
