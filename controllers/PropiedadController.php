<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedores;
use Intervention\Image\ImageManagerStatic as Imagen;

class PropiedadController {
    public static function index(Router $router) {

        $propiedades = Propiedad::all();
        $vendedores = Vendedores::all();

        //Mostrar mensaje condicional
        $resultado = $_GET["resultado"] ?? null;

        $router->render("propiedades/admin", [
            "propiedades" => $propiedades,
            "resultado" => $resultado,
            "vendedores" => $vendedores
        ]);
    }
    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedores::all();
        //Arreglo con mensajes de errores
        $errores = Propiedad::$errores;

        

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $propiedad = new Propiedad($_POST);

            if(!is_dir(CARPETA_IMAGEN)) { //is_dir sirve para saber si un directorio(carpeta) fue creado o no
                mkdir(CARPETA_IMAGEN);
            }
    
            /* SUBIDA DE ARCHIVOS */
            $nombreUnico = md5(uniqid(rand(), true)) . ".jpg";
    
            if($_FILES["imagen"]["tmp_name"]) {
                //Eliminar la imagen previa
                $imagen = Imagen::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
                $propiedad->setImagen($nombreUnico);
            }
    
            $errores = $propiedad->errores();
    
            //Revisar que el arreglo de errores este vacio
            if(empty($errores)) {
                if($_FILES["imagen"]["tmp_name"]) {
                    $imagen->save(CARPETA_IMAGEN . $propiedad->imagen);
                }
                $propiedad->guardar();
            }
        }

        $router->render("propiedades/crear", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
            "errores" => $errores
        ]);
    }
    public static function actualizar(Router $router) {
        $id = validarORedireccionar();
        //Obtener los datos de la propiedad
        $propiedad = Propiedad::find($id);
        //Consultar los vendedores
        $vendedores = Vendedores::all();
        //Arreglo con mensajes de errores
        $errores = Propiedad::$errores;

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $propiedad->sincronizar($_POST);
            
            /* SUBIDA DE ARCHIVOS */
            $nombreUnico = md5(uniqid(rand(), true)) . ".jpg";
    
            if($_FILES["imagen"]["tmp_name"]) {
                //Eliminar la imagen previa
                $imagen = Imagen::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
                $propiedad->setImagen($nombreUnico);
            }
    
            $errores = $propiedad->errores();
    
            //Revisar que el arreglo de errores este vacio
            if(empty($errores)) {
                //Realizar el query
                if($_FILES["imagen"]["tmp_name"]) {
                    $imagen->save(CARPETA_IMAGEN . $nombreUnico);
                }
                $propiedad->guardar();
    
            }
        }

        $router->render("propiedades/actualizar", [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
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
                    if($tipo === "propiedad") {
                        $propiedad = Propiedad::find($id);
                        $propiedad->borrar($id);
                    }
                }
            }
        }
    }
}