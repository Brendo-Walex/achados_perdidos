<?php
class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Verifica se um login já existe
    public function existeLogin($login) {
        $sql = "SELECT id_usuario FROM usuarios WHERE login = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->store_result();
        $existe = $stmt->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    
}
?>
