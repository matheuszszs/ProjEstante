<?php
class Comentario
{
    private $conn;
    private $table_name = "comentarios";


    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function registrar($idusu, $idliv, $data, $titulo, $comentario)
    {
        $query = "INSERT INTO " . $this->table_name . " (idusu, idliv, data, titulo, comentario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idusu, $idliv, $data, $titulo, $comentario]);
        return $stmt;
    }

    public function criar($idusu, $idliv, $data, $titulo, $comentario)
    {
        return $this->registrar($idusu, $idliv, $data, $titulo, $comentario);
    }
    public function ler($search = '', $order_by = '') {
        $query = "SELECT c.idcoment, u.nome  as usuario, c.comentarios";
        $conditions = [];
        $params = [];

        if ($search) {
           $conditions[] = "(titulo LIKE :search OR comentario LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($order_by === 'titulo') {
            $query .= " ORDER BY titulo";
        } elseif ($order_by === 'data') {
            $query .= " ORDER BY data";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    public function lerNotUsu($idusu){
        $query = "SELECT * FROM " . $this->table_name . " WHERE idusu = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idusu]);
        return $stmt;
    }
    public function lerPorIdliv($idliv){
        $query = "SELECT * FROM " . $this->table_name . " WHERE idliv = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idliv]);
        return $stmt;
    }
    public function lerPorId($idcoment)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idcoment = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idcoment]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($idusu, $idliv, $data, $titulo, $comentario, $idcoment)
    {
        $query = "UPDATE " . $this->table_name . " SET idusu = ?, idliv = ?, data = ?, titulo = ?, comentario = ? WHERE idcoment = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idusu, $idliv, $data, $titulo, $comentario,$idcoment]);
        return $stmt;
    }
    public function deletar($idcoment)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE idcoment = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idcoment]);
        return $stmt;
    }
}