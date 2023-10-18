<?php 

namespace Model;

class ActiveRecord {
    //atributos estaticos
    protected static $columnasDB = [];
    protected static $db;
    protected static $tabla = "";

    public static $errores = [];

    public static function setDB($database) {
        self::$db = $database;
    }
    public function setImagen($imagen) {
        if($this->id) {
            $this->borrarImagen();
        } 
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    public static function getErrores() {
        return static::$errores;
    }

    public function borrarImagen() {
        $existeArchivo = file_exists(CARPETA_IMAGEN . $this->imagen);
        if($existeArchivo) {
            unlink(CARPETA_IMAGEN . $this->imagen);
        }
    }

    public function guardar() {
        if($this->id) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }

    public function crear() {
        $atributos = $this->sanitizarAtributos();

        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(", ", array_keys($atributos));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";

        $resultado = self::$db->query($query);
        if($resultado) {
            header("Location: /admin?resultado=1");
        }
    }

    public function actualizar() {
        $atributos = $this->sanitizarAtributos();
        $array = [];
        foreach($atributos as $key => $value) {
            $array[] = "{$key} = '{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(", ", $array);
        $query .= " WHERE id = " . self::$db->escape_string($this->id);

        $resultado = self::$db->query($query);

        if($resultado) {
            //Redireccionar al usuario
            header("Location: /admin?resultado=2");
        }
    }

    public function borrar($id) {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = ${id}";
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header("Location: /admin?resultado=3");
        }
    }

    public function atributos() {
        $array = [];
        foreach(static::$columnasDB as $columnas) {
            if($columnas === "id") continue;
            $array[$columnas] = $this->$columnas;
        }
        return $array;
    }
    
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $array = [];
        
        foreach($atributos as $key => $value) {
            $array[$key] = self::$db->escape_string($value);
        }
        return $array;
    }
    //Validar
    public function errores() {
        
        static::$errores = [];

        return static::$errores;
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$tabla . "";
        $resultado = self::consultarSQL($query);
        
        return $resultado;
    }

    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        $resultado = self::consultarSQL($query);
        
        return $resultado;
    }
    
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        $resultado = self::$db->query($query);  
        $array = [];

        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        $resultado->free();

        return $array;
    }

    public static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value) {
            $objeto->$key = $value;
        }
        return $objeto;
    }

    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

}