<?php

namespace Model;

class Login extends ActiveRecord {
    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "email", "password"];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
    }

    public function errores() {
        if(!$this->email) {
            self::$errores[] = "El email es obligatorio";
        }
        if(!$this->password) {
            self::$errores[] = "El password es obligatorio";
        }
        return self::$errores;
    }

    public function usuarioExiste() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "'";
        $respuesta = self::$db->query($query);

        if(!$respuesta->num_rows) {
            self::$errores[] = "El usuario no existe";
            return;
        }
        return $respuesta;
    }
    public function comprobarPassword($resultado) {
        $usuario = $resultado->fetch_object();

        $resultado = password_verify($this->password, $usuario->password);
        if(!$resultado) {
            self::$errores[] = "El password es incorrecto";
            return;
        }
        return $resultado;
    }
    public function auntenticar() {
        session_start();

        $_SESSION["usuario"] = $this->email;
        $_SESSION["login"] = true;

        header("location: /admin");
    }
    
}