<?php

namespace Model;

class Vendedores extends ActiveRecord {
    protected static $columnasDB = ["id", "nombre", "apellido", "telefono"];
    protected static $tabla = "vendedores";

    //Atributos db
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    
    public function __construct($args = [])
    {   
        $this->id = $args["id"] ?? "";
        $this->nombre = $args["nombre"] ?? "";
        $this->apellido = $args["apellido"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
    }

    public function errores() {
        
        if(!$this->nombre) {
            self::$errores[] = "Debes añadir un nombre";
        }
        if(!$this->apellido) {
            self::$errores[] = "Debes añadir un apellido";
        }
        if(!$this->telefono) {
            self::$errores[] = "Debes añadir un numero telefonico de 10 digitos maximo";
        } else if(!preg_match("/[0-9]{10}/", $this->telefono)) {
            self::$errores[] = "Formato no valido";
        } else if(strlen($this->telefono) > 10) {
            self::$errores[] = "Telefonos de hasta 10 digitos";
        }

        return self::$errores;
    }
}


