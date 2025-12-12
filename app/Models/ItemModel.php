<?php
require_once __DIR__ . '/../Config/conexao.php';

class ItemModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getItemPorId($id_item) {
        $stmt = $this->conn->prepare("SELECT * FROM itens WHERE id_item = ?");
        $stmt->bind_param("i", $id_item);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function excluirItem($id_item) {
        $stmt = $this->conn->prepare("DELETE FROM itens WHERE id_item = ?");
        $stmt->bind_param("i", $id_item);
        return $stmt->execute();
    }
}
