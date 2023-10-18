<?php 

namespace Controllers;

use Model\Login;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {

        $errores = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new Login($_POST);

            $errores = $auth->errores();

            if(empty($errores)) {
                //Verificar si el usuario existe
                $resultado = $auth->usuarioExiste();

                
                if($resultado) {
                    //Verificar el password
                    $resultado = $auth->comprobarPassword($resultado);
                    if ($resultado) {
                        //Autenticar al usuario
                        $auth->auntenticar();
                    } else {
                        $errores = Login::getErrores();
                    }
                } else {
                    $errores = Login::getErrores();
                }

                
            }
        }
        $router->render("auth/login", [
            "errores" => $errores,
        ]);
    }
    public static function logout() {
        session_start();

        $_SESSION = [];

        header("location: /");
    }
}