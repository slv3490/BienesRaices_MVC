<?php

define("TEMPLATES_URL", __DIR__ . "/templates" );
define("FUNCIONES_URL", __DIR__ . "funciones.php");
define("CARPETA_IMAGEN", $_SERVER["DOCUMENT_ROOT"] . "/imagenes/");

function incluirTemmplates(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado(){
    session_start();
    $auth = $_SESSION["login"];
    if(!$auth) {
        header("location: /bienesraicesphp/index.php");
    }
}

function s($html) {
    $s = htmlspecialchars($html);
    return $s;
}

function validarTipo($tipo) {
    $tipos = ["vendedor", "propiedad"];
    return in_array($tipo, $tipos);
}

function debugear($bug) {
    echo "<pre>";
    var_dump($bug);
    echo "</pre>";

    exit;
}
function bug($bug) {
    echo "<pre>";
    var_dump($bug);
    echo "</pre>";
}

function mostrarAlerta($codigo) {
    $mensaje = "";

    switch($codigo) {
        case 1:
            $mensaje = "Registro Creado Correctamente";
            break;
        case 2:
            $mensaje = "Registro Actualizado Correctamente";
            break;
        case 3:
            $mensaje = "Registro Eliminado Correctamente";
            break;
        default: 
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar() {
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header("Location: /admin");
    }
    return $id;
}