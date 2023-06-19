<?php

class Listas {
    private $idLista;
    private $titulo;
    private $fechaDelEvento;
    private $descripcion;
    private $idUsuario;
    
    public function getidLista() {
        return $this->idLista;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getFechaDelEvento() {
		return $this->fechaDelEvento;
	}


    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setidLista($idLista): void {
        $this->idLista = $idLista;
    }

    public function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }

    public function setFechaDelEvento($fechaDelEvento): self {
		$this->fechaDelEvento = $fechaDelEvento;
		return $this;
	}

    public function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setIdUsuario($idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

}
