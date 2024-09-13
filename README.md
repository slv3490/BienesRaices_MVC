# Sobre el proyecto Bienes Raíces 🏠:
El proyecto **Bienes Raíces** ha representado una oportunidad de aprendizaje invaluable, durante la cual he adquirido un profundo conocimiento de patrones de arquitectura esenciales, como **ActiveRecord** y **Model-View-Controller (MVC)**. Además, he ganado una comprensión sólida del backend, incluyendo la administración, gestión y creación de bases de datos, así como el desarrollo e implementación de funcionalidades al proyecto.
## Funcionalidades
- Validación para todas las funcionalidades relacionadas al back-end
- Login
- C.R.U.D completo para propiedades y vendedores
- DarkMode con las preferencias del usuario
- Formulario de contacto

## Instalacíon
#### Dependencias
Para instalar las dependencias se debera escribir los siguientes comandos

`npm install`

`composer install`

#### Base de datos
Este proyecto cuenta con una base de datos por lo que se debera cambiar las variables de entorno de la misma que se encuentran en la carpeta **includes/config/database.php**. 

Las **tablas** y **columnas** se encontraran en la carpeta de modelos.


###### Propiedades
    protected static $columnasDB = ["id", "titulo", "precio", "imagen", "descripcion", "habitaciones", "wc", "estacionamiento", "creado", "vendedorId"];
    protected static $tabla = "propiedades";
###### Vendedores
    protected static $columnasDB = ["id", "nombre", "apellido", "telefono"];
    protected static $tabla = "vendedores";
###### Usuario
    protected static $columnasDB = ["id", "email", "password"];
	protected static $tabla = "usuarios";

#### Email
Este proyecto cuenta con envíos de emails por medio de **PHPMailer** por lo que se deberá cambíar las variables de entorno dentro de la carpeta **controllers/PaginasController.php** en la seccion de contacto para que el envio de email se realice correctamente.

## Estructura

#### Login

````
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
````

#### C.R.U.D de Propiedades (Create)
````
public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedores::all();  //Obtengo todos los vendedores
        //Arreglo con mensajes de errores
        $errores = Propiedad::$errores;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $propiedad = new Propiedad($_POST);

            if(!is_dir(CARPETA_IMAGEN)) {
                mkdir(CARPETA_IMAGEN);
            }
    
            /* SUBIDA DE ARCHIVOS */
            $nombreUnico = md5(uniqid(rand(), true)) . ".jpg";
    
            if($_FILES["imagen"]["tmp_name"]) {
                $imagen = Imagen::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
				//Elimina la imagen previa
                $propiedad->setImagen($nombreUnico);
            }
    
            $errores = $propiedad->errores();  //Funcion para validar
    
            //Verifico que el arreglo de errores este vacio
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
````

## 🛠 Skills
Html, Css, Javascript, Php y MySQL

## 🔗 Links
[![portfolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://github.com/slv3490/Portfolio) (En Proceso)

[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/leonel-silvera-5a9a75286/)

[![gmail](https://img.shields.io/badge/gmail-EA4335?style=for-the-badge&logo=gmail&logoColor=white)](https://mail.google.com/mail/u/0/?tab=rm&ogbl#search/leonelsilvera9%40gmail.com)

## Conclusión
Concluyo con satisfacción que este proyecto me ha dado resultados de alta calidad en cuanto a conocimientos en el ámbito del desarrollo full stack.
