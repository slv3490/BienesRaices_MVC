<?php 

namespace Model;

class Propiedad extends ActiveRecord {
    protected static $columnasDB = ["id", "titulo", "precio", "imagen", "descripcion", "habitaciones", "wc", "estacionamiento", "creado", "vendedorId"];
    protected static $tabla = "propiedades";

    //Atributos db
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

    public function __construct($args = [])
    {   
        $this->id = $args["id"] ?? "";
        $this->titulo = $args["titulo"] ?? "";
        $this->precio = $args["precio"] ?? "";
        $this->imagen = $args["imagen"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->habitaciones = $args["habitaciones"] ?? "";
        $this->wc = $args["wc"] ?? "";
        $this->estacionamiento = $args["estacionamiento"] ?? "";
        $this->creado = date("Y/m/d");
        $this->vendedorId = $args["vendedorId"] ?? "";
    }

    public function errores() {
        
        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un aña";
        }
        if(!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        } else if (strlen($this->precio) > 8) {
            self::$errores[] = "El precio debe ser menor o igual a 8 digitos";
        }
        if(!$this->descripcion) {
            self::$errores[] = "La descripcion es obligatoria";
        } else if(strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripcion debe tener almenos 50 caracteres";
        }
        if(!$this->habitaciones) {
            self::$errores[] = "El numero de habitaciones es obligatorio";
        }
        if(!$this->wc) {
            self::$errores[] = "El numero de baños es obligatorio";
        }
        if(!$this->estacionamiento) {
            self::$errores[] = "El numero de estacionamientos es obligatorio";
        }
        if(!$this->vendedorId) {
            self::$errores[] = "Elije un vendedor";
        }

        if(!$this->imagen) {
            self::$errores[] = "la imagen es obligatoria";
        }

        return self::$errores;
    }
}