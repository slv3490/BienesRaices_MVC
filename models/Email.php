<?php 

namespace Model;

class Email extends ActiveRecord {
    public $nombre;
    public $mensaje;
    public $opciones;
    public $presupuesto;
    public $contacto;
    public $telefono;
    public $fecha;
    public $hora;
    public $email;

    public function __construct($args = [])
    {
        $this->nombre = $args["nombre"] ?? "";
        $this->mensaje = $args["mensaje"] ?? "";
        $this->opciones = $args["opciones"] ?? "";
        $this->presupuesto = $args["presupuesto"] ?? "";
        $this->contacto = $args["contacto"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
        $this->fecha = $args["fecha"] ?? "";
        $this->hora = $args["hora"] ?? "";
        $this->email = $args["email"] ?? "";
    }

    public function errores() {
        if(!$this->nombre) {
            self::$errores[] = "El nombre es obligatorio";
        }
        if(!$this->mensaje) {
            self::$errores[] = "El mensaje es obligatorio";
        }
        if(!$this->opciones) {
            self::$errores[] = "Especifique si vende o compra";
        }
        if(!$this->presupuesto) {
            self::$errores[] = "El presupuesto es obligatorio";
        } else if (strlen($this->presupuesto) >= 8) {
            self::$errores[] = "El presupuesto debe ser menor o igual a 8 digitos";
        }
        if(!$this->contacto) {
            self::$errores[] = "Tiene que elegir una forma para ser contactado";
        }

        if($this->contacto === "telefono") {
            if(!$this->telefono) {
                self::$errores[] = "El telefono es obligatorio";
            }
            if(!$this->fecha) {
                self::$errores[] = "Especifique una fecha";
            }
            if(!$this->hora) {
                self::$errores[] = "Especifique una hora";
            }
        } else {
            if(!$this->email) {
                self::$errores[] = "El E-Mail es obligatorio";
            }
        }

        return self::$errores;
    }
}