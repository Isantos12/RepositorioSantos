<?php


class UsuarioDAO {
    private $conn;

    public function __construct($conn) {
        if (!$conn instanceof mysqli) { //Comprueba si $conn es un objeto de la clase mysqli
            return false;
        }
        $this->conn = $conn;
    }
    
    public function obtenerPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $usuario = $result->fetch_object('Usuario');
        //Para que netbeans reconozca el objeto de la clase Usuario  
        return $usuario;
    }

    public function obtenerUsuarioPorId($idUsuario){
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }

        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();

        $result = $stmt->get_result();
        $usuario = $result->fetch_object('Usuario');
        $stmt->close();

        return $usuario;
    }


    
    public function insertar(Usuario $u) {
        $sql = "INSERT INTO usuarios (email, password, nombre, rol) VALUES (?,?,?,?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $email = $u->getEmail();
        $password = $u->getPassword();
        $nombre = $u->getNombre();
        $rol = "user";
        

        $stmt->bind_param('ssss', $email, $password, $nombre, $rol);
        $stmt->execute();
    }
    
    public function actualizar(Usuario $u) {
        $sql = "UPDATE usuarios SET email = ? , cookie = ? "
                . "WHERE id = ?";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $id = $u->getId();
        $email = $u->getEmail();
        $cookie = $u->getCookie();
        $stmt->bind_param('ssi', $email, $cookie, $id);
        $stmt->execute();
    }

    public function obtenerTodosUsuarios() {
        $sql = "SELECT * FROM usuarios";
        if (!$result = $this->conn->query($sql)) {
            die("Error al ejecutar la SQL " . $this->conn->error);
        }
        $array_usuarios = array();
        while ($usuario = $result->fetch_object('Usuario')) {
            $array_usuarios[] = $usuario;
        }
        return $array_usuarios;
    }


    public function buscarAdmin($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ? AND rol = 'admin'";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la sentencia: " . $this->conn->error);
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        return $usuario;
    }

    public function editarUsuario(Usuario $usuario)
{   
    $sql = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?";
    $stmt = $this->conn->prepare($sql);

    $nombre = $usuario->getNombre();
    $email = $usuario->getEmail();
    $rol = $usuario->getRol();
    $id = $usuario->getId();

    $stmt->bind_param("sssi",$nombre, $email, $rol, $id);

    if (!$stmt->execute()) {
        die("Error al editar el usuario: " . $stmt->error);
    }
}


    public function eliminarUsuario($idUsuario){

        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idUsuario);

        if (!$stmt->execute()) {
            die("Error al eliminar el usuario: " . $stmt->error);
        }
    }

    
    



}

