<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedores;

class VendedorController {
    public static function crear(Router $router) {
        //Arreglo con mensajes de errores
        $errores = Vendedores::$errores;

        $vendedor = new Vendedores;

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $vendedor = new Vendedores($_POST);

            $errores = $vendedor->errores();

            //Revisar que el arreglo de errores este vacio
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render("vendedores/crear", [
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);
    }
    public static function actualizar(Router $router) {

        $id = validarORedireccionar();

        $vendedor = Vendedores::find($id);

        //Arreglo con mensajes de errores
        $errores = Vendedores::$errores;

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $vendedor->sincronizar($_POST);

            $errores = $vendedor->errores();

            //Revisar que el arreglo de errores este vacio
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render("vendedores/actualizar", [
            "vendedor" => $vendedor,
            "errores" => $errores
        ]);
    }
    public static function eliminar() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
                $tipo = $_POST["tipo"];
    
                if(validarTipo($tipo)) {
                    if($tipo === "vendedor") {
                        $vendedor = Vendedores::find($id);
                        $vendedor->borrar($id);
                    }
                }
            }
        }
    }
}