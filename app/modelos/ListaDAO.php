<?php


class ListasDAO {
    private $conn;

    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }
    
    public function obtenerTodasLasListas() {
        $sql = "SELECT l.*, u.nombre AS nombre_usuario FROM listas l JOIN usuarios u ON l.idUsuario = u.id ORDER BY l.fecha DESC";
        if (!$result = $this->conn->query($sql)) {
            die("Error al ejecutar la SQL " . $this->conn->error);
        }
        $array_listas = array();
        while ($lista = $result->fetch_object('Listas')) {
            $array_listas[] = $lista;
        }
        return $array_listas;
    }
    
    
    public function insertar(Listas $li, $foto) {
        $sql = "INSERT INTO listas (titulo, fechaDelEvento, descripcion, idUsuario) VALUES (?, ?, ?, ?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        
        $titulo = $li->getTitulo();
        $fechaDelEvento = $li->getFechaDelEvento();
        $descripcion = $li->getDescripcion();
        $idUsuario = $li->getIdUsuario();
        
        $stmt->bind_param('sssi', $titulo, $fechaDelEvento, $descripcion, $idUsuario);
        $stmt->execute();
        
        // Obtén el ID de la lista recién insertada
        $idLista = $stmt->insert_id;
        
        // Inserta la foto en la tabla correspondiente
        $sqlFoto = "INSERT INTO fotos (idLista, foto) VALUES (?, ?)";
        if (!$stmtFoto = $this->conn->prepare($sqlFoto)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        
        // Asigna el ID de la lista y el nombre de archivo de la foto
        $stmtFoto->bind_param('is', $idLista, $foto);
        $stmtFoto->execute();
        
        return $idLista;
    }
    
    
    
    
    public function obtener(int $id) {
        $sql = "SELECT * FROM listas WHERE idLista = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        return $result->fetch_object('Listas');
    }
    
    public function borrar(Listas $li) {
        $sql = "DELETE FROM listas WHERE idLista = ? ";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }   
        $id = $li->getidLista();
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        if($stmt->affected_rows==0){
            return false;
        }
        else{
            return true;
        }
    }
    
    public function actualizar(Listas $li) {
        $sql = "UPDATE listas SET titulo = ? , fechaDelEvento = ?, descripcion = ? "
                . "WHERE idLista = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }   
        $id = $li->getidLista();
        $titulo = $li->getTitulo();
        $descripcion = $li->getDescripcion();
        $fechaDelEvento = $li->getFechaDelEvento();
        $stmt->bind_param('sisi', $titulo, $fechaDelEvento, $descripcion, $id);
        $stmt->execute();
        
    }
    
    public function obtenerListaPoridLista($idLista){        
        $sql = "SELECT * FROM listas WHERE idLista = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('i', $idLista);
        $stmt->execute();

        $result = $stmt->get_result();
        $array_listas = array();
        while ($listas = $result->fetch_object('Listas')) {
            $array_listas[] = $listas;
        }
        return $array_listas;

    }
    

    
}
