<?php

namespace App;

class ActiveRecord
{
    //Base de datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];
    //Errores
    protected static $errores = [];


    //Definir la conexión a la base de datos como static
    public static function setDB($database)
    {
        //SELF HACE REFERENCIA A LOS ATRIBUTOS STATIC DE LA CLASE
        self::$db = $database;
    }

    public function guardar()
    {
        if (!is_null($this->id)) {
            //Actualizar
            $this->actualizar();
        } else {
            //Crear un registro
            $this->crear();
        }
    }
    public function crear()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarDatos();
        $string = join(', ', array_keys($atributos)); //-> Convierte el array en un string


        //Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos)); //
        $query .= ") VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);
        if ($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
    }
    public function actualizar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarDatos();
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query); //-> Ejecuta la consulta
        if ($resultado) {
            header('Location: /admin?resultado=2');
        }
    }
    //Eliminar un registro
    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
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
        //Elimina la imagen previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        //Asignar al atributo imagen el nombre de la imagen.
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
    //Elimina la imagen del servidor
    public function borrarImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }
    //Lista todas los registros.
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    //Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query); //Pasamos el query a la función consultarSQL
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
        $objeto = new static;

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
