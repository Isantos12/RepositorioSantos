<?php

class Cancion {
    
    private $idCancion;
    private $idLista;
    private $titulo;
    private $momento;
	private $notas;
    private $ruta;
        
	
	

	/**
	 * @return mixed
	 */
	public function getIdCancion() {
		return $this->idCancion;
	}
	
	/**
	 * @return mixed
	 */
	public function getIdLista() {
		return $this->idLista;
	}
	
	/**
	 * @return mixed
	 */
	public function getTitulo() {
		return $this->titulo;
	}
	
	/**
	 * @return mixed
	 */
	public function getMomento() {
		return $this->momento;
	}
	
	/**
	 * @return mixed
	 */
	public function getNotas() {
		return $this->notas;
	}
	
	/**
	 * @return mixed
	 */
	public function getRuta() {
		return $this->ruta;
	}

	/**
	 * @param mixed $idCancion 
	 * @return self
	 */
	public function setIdCancion($idCancion): self {
		$this->idCancion = $idCancion;
		return $this;
	}
	
	/**
	 * @param mixed $idLista 
	 * @return self
	 */
	public function setIdLista($idLista): self {
		$this->idLista = $idLista;
		return $this;
	}
	
	/**
	 * @param mixed $titulo 
	 * @return self
	 */
	public function setTitulo($titulo): self {
		$this->titulo = $titulo;
		return $this;
	}
	
	/**
	 * @param mixed $momento 
	 * @return self
	 */
	public function setMomento($momento): self {
		$this->momento = $momento;
		return $this;
	}
	
	/**
	 * @param mixed $notas 
	 * @return self
	 */
	public function setNotas($notas): self {
		$this->notas = $notas;
		return $this;
	}
	
	/**
	 * @param mixed $ruta 
	 * @return self
	 */
	public function setRuta($ruta): self {
		$this->ruta = $ruta;
		return $this;
	}
}
