<?php
class ListasController
{
    function inicio()
    {
        $listaDAO = new ListasDAO(ConexionBD::conectar());
        $fotoDAO = new FotoDAO(ConexionBD::conectar());
        $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
        //Obtengo todos los mensajes de la BD
        $listas = $listaDAO->obtenerTodasLasListas();
        $fotos = $fotoDAO->obtenerTodasFotos();
        $usuarios = $usuarioDAO->obtenerTodosUsuarios();
        //incluimos la vista
        require 'app/vistas/inicio.php';
    }

    function inicioMisListas()
    {
        $listaDAO = new ListasDAO(ConexionBD::conectar());
        $fotoDAO = new FotoDAO(ConexionBD::conectar());
        //Obtengo todos los mensajes de la BD
        $listas = $listaDAO->obtenerTodasLasListas();
        $fotos = $fotoDAO->obtenerTodasFotos();
        //incluimos la vista
        require 'app/vistas/mislistas.php';
    }


    function sobreMi()
    {

        require 'app/vistas/sobreMi.php';
    }

    


    function vistaLista()
    {   
        $idLista = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $listaDAO = new ListasDAO(ConexionBD::conectar());
        $fotoDAO = new FotoDAO(ConexionBD::conectar());
        $cancionDAO = new CancionDAO(ConexionBD::conectar());
        $listas = $listaDAO->obtenerListaPoridLista($idLista);
        $fotos = $fotoDAO->obtenerTodasFotos();
        $canciones = $cancionDAO->obtenerTodasCanciones();

        require 'app/vistas/vista_listas.php';
    }

    function insertar()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtén los valores del formulario
        $descripcion = $_POST['descripcion'];
        $titulo = $_POST['titulo'];
        $fechaDelEvento = $_POST['fechaDelEvento'];

        // Crear instancia de Listas y asignar los valores
        $lista = new Listas();
        $lista->setDescripcion($descripcion);
        $lista->setTitulo($titulo);
        $lista->setFechaDelEvento($fechaDelEvento);
        $lista->setIdUsuario($_SESSION['idUsuario']);

        // Obtener el archivo de imagen subido
        $foto = $_FILES['foto'];

        // Ruta de destino para guardar la imagen
        $rutaDestino = 'web/img/' . $foto['name'];

        // Guardar la imagen en la carpeta de destino
        if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
            // La imagen se ha guardado correctamente

            // Crear instancia de ListasDAO
            $listaDAO = new ListasDAO(ConexionBD::conectar());

            // Insertar la lista y la ruta de la imagen en la base de datos
            $idLista = $listaDAO->insertar($lista, $rutaDestino);

            // Realizar cualquier otra acción necesaria, como redireccionar a otra página
            header("Location: index.php");
            die();
        } else {
            // Hubo un error al guardar la imagen
            // Manejar el error según tus necesidades
        }
    } else {
        require 'app/vistas/insertar_lista.php';
    }
}

    


    function borrar()
{
    $idLista = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $idUsuarioConectado = $_SESSION['idUsuario'];
    $rolUsuarioConectado = $_SESSION['rol'];

    $listaDAO = new ListasDAO(ConexionBD::conectar());
    if (!$listas = $listaDAO->obtener($idLista)) {
        MensajeFlash::guardarMensaje("La lista no existe");
        header("Location: index.php");
        die();
    }

    // Compruebo que el usuario conectado es el "creador" de la lista que queremos borrar o es administrador
    if ($listas->getIdUsuario() != $idUsuarioConectado && $rolUsuarioConectado != 'admin') {
        MensajeFlash::guardarMensaje("No tienes permisos para borrar la lista");
        header("Location: index.php");
        die();
    }

    // Borro la lista
    $listaDAO->borrar($listas);
    MensajeFlash::guardarMensaje("Lista borrada correctamente");
    header("Location: index.php");
}


    function modificar()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $listaDAO = new ListasDAO(ConexionBD::conectar());
        $listas = new Listas();
        $listas = $listaDAO->obtener($id);
        $fotosDAO = new FotoDAO(ConexionBD::conectar());
        $fotos = $fotosDAO->obtenerPoridLista($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $titulo = htmlentities($_POST['titulo']);
            $fechaDelEvento = htmlentities($_POST['fechaDelEvento']);
            $descripcion = htmlentities($_POST['descripcion']);

            $listas->setTitulo($titulo);
            $listas->setFechaDelEvento($fechaDelEvento);
            $listas->setDescripcion($descripcion);

            $listaDAO->actualizar($listas);
            header("Location: index.php");
        } else {
            $idllega = $_GET['id'];
            $conn = ConexionBD::conectar();
            $listaDAO = new ListasDAO($conn);
            $listas = $listaDAO->obtener($idllega);
            require 'app/vistas/modificar_lista.php';
        }

    }

    function insertarfoto()
    {
        move_uploaded_file($_FILES['foto']['tmp_name'], "web/img/" .
            $_FILES['foto']['name']);
        $fotoDAO = new FotoDAO(ConexionBD::conectar());
        $foto = new Foto();
        $foto->setFoto("web/img/".$_FILES['foto']['name']);
        $foto->setidLista($_GET['id']);
        $idFoto = $fotoDAO->insertar($foto);

        print json_encode(['resultado' => true, 'foto' => "web/img/".$_FILES['foto']['name'], 'id' => $idFoto]);

    }

    function borrar_foto_ajax()
    {
        header("Content-type: application/json; charset=utf-8");
        $idListaF = filter_var($_GET['idfoto'], FILTER_SANITIZE_NUMBER_INT);
        $foto = new Foto();
        $fotoaDAO = new FotoDAO(ConexionBD::conectar());
        if (!$foto = $fotoaDAO->obtenerPorIdFoto($idListaF)) {
            print json_encode(["borrado" => false, "mensaje" => "La foto no existe"]);
            die();
        }

        if ($fotoaDAO->borrar_foto($idListaF)) {
            print json_encode(["borrado" => true]);
        } else {
            print json_encode(["borrado" => false]);
        }
    }


    function anadir_cancion_2()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idLista = filter_var($_POST['idLista'], FILTER_SANITIZE_NUMBER_INT);

        $titulo = htmlentities($_POST['titulo']);
        $momento = htmlentities($_POST['momento']);
        $notas = htmlentities($_POST['notas']);
        
        $response = array(
            'resultado' => true,
            'message' => 'La canción ha sido insertada correctamente.'
        );

        if (isset($_FILES['cancion'])) {
            
            $cancionObj = new Cancion();
            $cancionObj->setTitulo($titulo);
            $cancionObj->setMomento($momento);
            $cancionObj->setNotas($notas);

            move_uploaded_file($_FILES['cancion']['tmp_name'], "web/music/" . $_FILES['cancion']['name']);
            $rutaCancion = "web/music/" . $_FILES['cancion']['name'];

            $cancionObj->setRuta($rutaCancion);

            $cancionObj->setIdLista($idLista);
            $cancionDAO = new CancionDAO(ConexionBD::conectar());
            $cancionDAO->insertar($cancionObj);
        }

        header("Content-type: application/json; charset=utf-8");
        echo json_encode($response);
        exit;
    }
}

    

}