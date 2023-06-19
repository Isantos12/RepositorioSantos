<?php

class UsuariosController {

    function registrar() {
        //Inicializamos las variables en blanco para que no den error al imprimirlos en los values 
        //cuando cargamos la página la primera vez.
        $email = "";
        $password = "";
        $nombre = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuario();
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
            $error = false;
            
            // Validar el formato del email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            MensajeFlash::guardarMensaje("El formato del email es inválido");
            $error = true;
        }
            //Comprobamos si existe un usuario con el mismo email
            $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
            if ($usuarioDAO->obtenerPorEmail($email)) {
                //Ya existe un usuario con el mismo email
                MensajeFlash::guardarMensaje("Email repetido");
                $error = true;
            }

            if (!$error) {                
                $passwordCodificada = password_hash($password, PASSWORD_BCRYPT);
                $usuario->setEmail($email);
                $usuario->setPassword($passwordCodificada);
                $usuario->setNombre($nombre);
                $usuarioDAO->insertar($usuario);

                header('Location: index.php');
                die();
            }
        }
        require 'app/vistas/registrar2.php';
    }

    function login()
{
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $usuDAO = new UsuarioDAO(ConexionBD::conectar());
    $usu = $usuDAO->obtenerPorEmail($email);

    if (!$usu) {  // El usuario con ese email no existe.
        MensajeFlash::guardarMensaje("El usuario o la contraseña no son válidos");
        header("Location: index.php");
        die();
    } elseif (!password_verify($password, $usu->getPassword())) {   // Login incorrecto
        MensajeFlash::guardarMensaje("La contraseña no es válida");
        header("Location: index.php");
        die();
    } else {
        // Usuario y contraseña son correctos.
        if ($usu->getRol() == "admin") {  // Verificar si el usuario es administrador
            // Iniciamos sesión como administrador
            $_SESSION['email'] = $usu->getEmail();
            $_SESSION['idUsuario'] = $usu->getId();
            $_SESSION['rol'] = $usu->getRol();


            // Guardado de cookie. Generamos un uid aleatorio y lo guardamos en la BD y en la cookie
            $uid = sha1(time() + rand()) . md5(time());
            $usu->setCookie($uid);
            $usuDAO->actualizar($usu);
            setcookie("uid", $uid, time() + (60 * 60 * 24 * 20), "/");

            header("Location: index.php");
            die();
        } else {
            // Iniciamos sesión como usuario normal
            $_SESSION['email'] = $usu->getEmail();
            $_SESSION['idUsuario'] = $usu->getId();
            $_SESSION['rol'] = $usu->getRol();

            // Guardado de cookie. Generamos un uid aleatorio y lo guardamos en la BD y en la cookie
            $uid = sha1(time() + rand()) . md5(time());
            $usu->setCookie($uid);
            $usuDAO->actualizar($usu);
            setcookie("uid", $uid, time() + (60 * 60 * 24 * 20), "/");

            header("Location: index.php");
            die();
        }
    }
}


    function logout() {
        session_destroy();
        setcookie("uid", "", 0);
        header("Location: index.php");
    }

    //Se va a utilizar desde una conexión AJAX
    function comprobar_email() {
        //Indicar al navegador que la respuesta es un json
        header("Content-type: application/json; charset=utf-8");

        //Si no se ha enviado el email por post devolvemos un mensaje de error
        if (!isset($_POST['email'])) {
            print json_encode(["error" => "Falta parámetro email"]);
            die();
        }
        
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
        if ($usuarioDAO->obtenerPorEmail($email) != false) {
            //Devolvemos un json
            print json_encode(["repetido" => true]);
        } else {
            print json_encode(["repetido" => false]);
        }
        //Para simular un retardo en el servidor. Se quita después en producción.
        sleep(1);
    }


    function admin_area()
    {
        $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
        $usuarios = $usuarioDAO->obtenerTodosUsuarios();

        require 'app/vistas/admin_area.php';
    }

    public function eliminarUsuarioAJAX()
    {   
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    // Obtener el ID del usuario desde el formulario o la solicitud Ajax
    $idUsuario = $_POST['idUsuario'];

    // Llamar al método eliminarUsuario del UsuarioDAO
    $usuarioDAO->eliminarUsuario($idUsuario);

    // Enviar una respuesta, por ejemplo, un mensaje de éxito
    $response = array('mensaje' => 'Usuario eliminado exitosamente');
    echo json_encode($response);
    } 
    
    public function editarUsuarioAJAX()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtener los datos enviados por AJAX
        $idUsuario = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];

        $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
        $usuario = $usuarioDAO->obtenerUsuarioPorId($idUsuario);

        if ($usuario) {
            $usuario->setNombre($nombre);
            $usuario->setEmail($email);
            $usuario->setRol($rol);
            $usuarioDAO->editarUsuario($usuario);

            // Preparar la respuesta en formato JSON
            $response = ['mensaje' => 'Usuario editado exitosamente'];

            // Enviar la respuesta como JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }
}

public function obtener_usuario_Ajax()
{
    $idUsuario = $_POST['idUsuario'];

    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->obtenerUsuarioPorId($idUsuario);

    if ($usuario) {
        // Construir un arreglo con los datos del usuario
        $datosUsuario = [
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
            'email' => $usuario->getEmail(),
            'rol' => $usuario->getRol()
        ];

        // Devolver los datos del usuario en formato JSON
        echo json_encode(['usuario' => $datosUsuario]);
    } else {
        // Si no se encuentra el usuario, devolver un mensaje de error
        echo json_encode(['error' => 'No se encontró el usuario']);
    }

    exit();
}



    

}
