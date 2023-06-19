<?php
//Para utilizar variables de sesión
session_start();

//////// CONTROLADOR FRONTAL /////////

/* REQUIRES DE MODELOS, CONTROLADORES Y CONFIG */
require './app/config.php';
require './app/controladores/ListasController.php';
require './app/controladores/UsuariosController.php';
require './app/controladores/CancionesController.php';
require './app/modelos/ConexionBD.php';
require './app/modelos/Usuario.php';
require './app/modelos/Listas.php';
require './app/modelos/ListaDAO.php';
require './app/modelos/UsuarioDAO.php';
require './app/modelos/FotoDAO.php';
require './app/modelos/Foto.php';
require './app/modelos/CancionDAO.php';
require './app/modelos/Cancion.php';
require './app/utilidades/MensajeFlash.php';


/* MAPA DE ENRUTAMIENTO */
$map = array (
    "login" => array("controller" => "UsuariosController", "method" => "login", "publica" => true),
    "logout" => array("controller" => "UsuariosController", "method" => "logout", "publica" => false),
    "registrar" => array("controller" => "UsuariosController", "method" => "registrar", "publica" => true),
    "admin_area" => array("controller" => "UsuariosController", "method" => "admin_area", "publica" => true),
    "inicio" => array("controller" => "ListasController", "method" => "inicio", "publica" => true),

    "sobreMi" => array("controller" => "ListasController", "method" => "sobreMi", "publica" => true),
    "anadir_cancion_2" => array("controller" => "ListasController", "method" => "anadir_cancion_2", "publica" => true),
    "borrar_cancion_Ajax" => array("controller" => "CancionesController", "method" => "borrarcancionAJAX", "publica" => true),

    "borrar_usuario_Ajax" => array("controller" => "UsuariosController", "method" => "eliminarUsuarioAJAX", "publica" => true),
    "editar_usuario_Ajax" => array("controller" => "UsuariosController", "method" => "editarUsuarioAJAX", "publica" => true),
    "obtener_usuario_Ajax" => array("controller" => "UsuariosController", "method" => "obtener_usuario_Ajax", "publica" => true),
    

    "inicioMisListas" => array("controller" => "ListasController", "method" => "inicioMisListas", "publica" => true),
    "vista_listas" => array("controller" => "ListasController", "method" => "vistaLista", "publica" => true),
    "insertar_lista" => array("controller" => "ListasController", "method" => "insertar", "publica" => false),
    "borrar_lista" => array("controller" => "ListasController", "method" => "borrar", "publica" => false),
    "modificar_lista" => array("controller" => "ListasController", "method" => "modificar", "publica" => false),
    "modificarfoto_lista" => array("controller" => "ListasController", "method" => "insertarfoto", "publica" => true),
    "comprobar_email" => array("controller" => "UsuariosController", "method" =>"comprobar_email", "publica" => true),


    "borrar_foto_ajax" => array("controller" => "ListasController", "method" => "borrar_foto_ajax", "publica" => true),

);
    
/* PARSEO DE LA RUTA */
if (!isset($_GET['action'])) {    
    $action = 'inicio';
} else {
    if (!isset($map[$_GET['action']])) {  
        print "La acción indicada no existe.";
        header('Status: 404 Not Found');
        die();
    } else {
        $action = filter_var($_GET['action'], FILTER_SANITIZE_SPECIAL_CHARS);
    }
}

/* CONTROL DE ACCESO MEDIANTE VARIABLES DE SESIÓN */
if (!$map[$action]["publica"] && !isset($_SESSION['idUsuario'])) {
    MensajeFlash::guardarMensaje("Debes identificarte");
    header("Location: index.php");
    die();
}

/* EJECUTAMOS EL CONTROLADOR NECESARIO */

$controller = $map[$action]['controller'];
$method = $map[$action]['method'];

if (method_exists($controller, $method)) {
    $obj_controller = new $controller();
    $obj_controller->$method();
} else {
    header('Status: 404 Not Found');
    echo "El método $method del controlador $controller no existe.";
}
