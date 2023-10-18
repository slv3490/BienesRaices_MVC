<?php

namespace Controllers;

use MVC\Router;
use Model\Email;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        
        $propiedades = Propiedad::get(3);
        
        $router->render("paginas/index", [
            "propiedades" => $propiedades,
            "inicio" => true
        ]);
    }
    public static function nosotros(Router $router) {
        $router->render("paginas/nosotros");
    }
    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();

        $router->render("paginas/propiedades", [
            "propiedades" => $propiedades
        ]);
    }
    public static function propiedad(Router $router) {

        $id = validarORedireccionar();
        $propiedades = Propiedad::find($id);

        $router->render("paginas/propiedad", [
            "propiedad" => $propiedades
        ]);
    }
    public static function blog(Router $router) {
        $router->render("paginas/blog");
    }
    public static function entrada(Router $router) {
        $router->render("paginas/entrada");
    }
    public static function contacto(Router $router) {
            
        $mensaje = null;
        $errores = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $respuestas = new Email($_POST);
            $errores = $respuestas->errores();

            if(empty($errores)) {
                $mail = new PHPMailer;

                //Server settings
                $mail->isSMTP();
                $mail->Host = $_ENV["EMAIL_HOST"];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV["EMAIL_USER"];
                $mail->Password = $_ENV["EMAIL_PASS"];
                $mail->SMTPSecure = "tls";
                $mail->Port = $_ENV["EMAIL_PORT"];
    
                $mail->setFrom('admin@bienesraices.com');
                $mail->addAddress('admin@bienesraices.com', "BienesRaices.com");
                $mail->Subject = "Tienes un nuevo mensaje";
     
                //Content
                $mail->isHTML(true);
                $mail->CharSet = "UTF-8";
    
                $contenido = "<html>";
                $contenido .= "<p>Nombre: " . $respuestas->nombre . "</p>";
                $contenido .= "<p>mensaje: " . $respuestas->mensaje . "</p>";
                $contenido .= "<p>presupuesto: " . $respuestas->presupuesto . "</p>";
                $contenido .= "<p>Compra o Venta: " . $respuestas->opciones . "</p>";
                if ($respuestas->contacto === "telefono") {
                    $contenido .= "El usuario prefirio ser contactado a traves de un numero telefonico";
                    $contenido .= "<p>telefono: " . $respuestas->telefono . "</p>";
                    $contenido .= "<p>fecha: " . $respuestas->fecha . "</p>";
                    $contenido .= "<p>hora: " . $respuestas->hora . "</p>";
                } else {
                    $contenido .= "El usuario prefirio ser contactado a traves de E-Mail";
                    $contenido .= "<p>E-mail: " . $respuestas->email . "</p>";
                }
                $contenido .="</html>";
    
                $mail->Body = $contenido;
                $mail->AltBody = "Esto es texto alternativo sin HTML";
    
                if($mail->send()) {
                    $mensaje = "Mensaje enviado correctamente";
                } else {
                    $mensaje = "El mensaje no pudo ser enviado";
                }
            }

            
        }
        $router->render("paginas/contacto", [
            "mensaje" => $mensaje,
            "errores" => $errores
        ]);
    }
}