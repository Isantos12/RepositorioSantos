<?php


class CancionDAO {
    private $conn;

    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }
    
    public function obtenerTodasCanciones() {
        $sql = "SELECT * FROM canciones";
        if (!$result = $this->conn->query($sql)) {
            die("Error al ejecutar la SQL " . $this->conn->error);
        }
        $array_canciones = array();
        while ($cancion = $result->fetch_object('Cancion')) {
            $array_canciones[] = $cancion;
        }
        return $array_canciones;
    }

    public function obtenerCancionesPoridLista($idLista){        
        $sql = "SELECT * FROM canciones WHERE idLista = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('i', $idLista);
        $stmt->execute();

        $result = $stmt->get_result();
        $array_canciones = array();
        while ($cancion= $result->fetch_object('Cancion')) {
            $array_canciones[] = $cancion;
        }
        return $array_canciones;

    }


    public function insertar(Cancion $c) {
        $sql = "INSERT INTO canciones (titulo, momento, notas, ruta, idLista) VALUES (?,?,?,?,?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $titulo = $c->getTitulo();
        $momento = $c->getMomento();
        $notas = $c->getNotas();
        $ruta = $c->getRuta();
        
        $idLista = $c->getIdLista();
        
        $stmt->bind_param('ssssi', $titulo, $momento, $notas, $ruta, $idLista);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function obtener(int $id) {
        $sql = "SELECT * FROM canciones WHERE idCancion = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        return $result->fetch_object('Cancion');
    }


    public function borrar(Cancion $cancion) {
        $sql = "DELETE FROM canciones WHERE idCancion = ?";
        
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        
        $idCancion = $cancion->getIdCancion();
        $stmt->bind_param('i', $idCancion);
        $stmt->execute();
    
        if ($stmt->affected_rows == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    
    
}