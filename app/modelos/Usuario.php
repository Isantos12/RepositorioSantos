<?php

class Usuario {
    private $id; 
    private $email;
    private $password;
    private $nombre;
    private $telefono;
    private $poblacion;
    private $cookie;
    private $rol;


    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getPoblacion() {
        return $this->poblacion;
    }

    public function getCookie() {
        return $this->cookie;
    }

	public function getRol() {
		return $this->rol;
	}
    
    public function setId($id): void {
        $this->id = $id;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setTelefono($telefono): void {
        $this->telefono = $telefono;
    }

    public function setPoblacion($poblacion): void {
        $this->poblacion = $poblacion;
    }

    public function setCookie($cookie): void {
        $this->cookie = $cookie;
    }
    
	public function setRol($rol): self {
		$this->rol = $rol;
		return $this;
	}
}
