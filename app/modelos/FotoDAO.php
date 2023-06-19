<?php

class FotoDAO {
    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }
    
    public function insertar(Foto $f) {
        
        $sql = "INSERT INTO fotos (idLista ,foto ) VALUES (?,?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $idLista = $f->getidLista();
        $foto = $f->getFoto();        
        $stmt->bind_param('is', $idLista,$foto);
        $stmt->execute();
        
        return $stmt->insert_id;
    }
    
    public function obtenerPoridLista($idLista){        
        $sql = "SELECT * FROM fotos WHERE idLista = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('i', $idLista);
        $stmt->execute();

        $result = $stmt->get_result();
        $array_fotos = array();
        while ($foto = $result->fetch_object('Foto')) {
            $array_fotos[] = $foto;
        }
        return $array_fotos;

    }
    
    public function borrar_foto($id) {
        $sql = "DELETE FROM fotos WHERE idFoto = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }   
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        if($stmt->affected_rows==0){
            return false;
        }
        else{
            return true;
        }
    }
    
    public function obtenerPorIdFoto($idLista){        
        $sql = "SELECT * FROM fotos WHERE idFoto = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('i', $idLista);
        $stmt->execute();

        $result = $stmt->get_result();
        $array_fotos = array();
        while ($foto = $result->fetch_object('Foto')) {
            $array_fotos[] = $foto;
        }
        return $array_fotos;

    }
    
    
    public function obtenerTodasFotos() {
        $sql = "SELECT * FROM fotos ";
        if (!$result = $this->conn->query($sql)) {
            die("Error al ejecutar la SQL " . $this->conn->error);
        }
        $array_fotos = array();
        while ($foto = $result->fetch_object('Foto')) {
            $array_fotos[] = $foto;
        }
        return $array_fotos;
    }


    
    
}
