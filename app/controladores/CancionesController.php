<?php
class CancionesController {
    // ...

    public function borrarcancionAJAX() {
        // Obtén el ID de la canción a eliminar
        $cancionId = $_POST['cancionId'];

        // Crea una instancia del DAO de Canciones
        $cancionDAO = new CancionDAO(ConexionBD::conectar());
        // Obtén la canción por su ID
        $cancion = $cancionDAO->obtener($cancionId);

        // Verifica si la canción existe y puede ser borrada
        if ($cancion) {
            // Intenta borrar la canción
            if ($cancionDAO->borrar($cancion)) {
                // La canción se borró correctamente
                $response = array(
                    'resultado' => true,
                    'message' => 'La canción se ha eliminado correctamente.'
                );
            } else {
                // Error al borrar la canción
                $response = array(
                    'resultado' => false,
                    'message' => 'Error al eliminar la canción.'
                );
            }
        } else {
            // La canción no existe o no puede ser borrada
            $response = array(
                'resultado' => false,
                'message' => 'La canción no existe o no puede ser borrada.'
            );
        }

        // Devuelve la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // ...
}
