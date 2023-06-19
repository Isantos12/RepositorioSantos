<?php

class Foto {
    private $idFoto;
    private $idLista;
    private $foto;
    
    public function getIdFoto() {
        return $this->idFoto;
    }

    public function getidLista() {
        return $this->idLista;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setIdFoto($idFoto): void {
        $this->idFoto = $idFoto;
    }

    public function setidLista($idLista): void {
        $this->idLista = $idLista;
    }

    public function setFoto($foto): void {
        $this->foto = $foto;
    }


    
    


}
