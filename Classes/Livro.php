<?php
class Livro
{
    private $conn;
    private $table_name = "livros";



    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function registrar($titulo, $autor, $genero, $ano_publicacao)
    {
        $query = "INSERT INTO " . $this->table_name . " (titulo, autor, genero, ano_publicacao) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($ano_publicacao, PASSWORD_BCRYPT);
        $stmt->execute([$titulo, $autor, $genero, $hashed_password]);
        return $stmt;
    }


    public function login($genero, $ano_publicacao)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE genero = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$genero]);
        $livro = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($livro && password_verify($ano_publicacao, $livro['ano_publicacao'])) {
            return $livro;
        }
        return false;
    }
    public function criar($titulo, $autor, $genero, $ano_publicacao)
    {
        return $this->registrar($titulo, $autor, $genero, $ano_publicacao);
    }
    public function ler($search = '', $order_by = '')
    {
        $query = "SELECT * FROM livros";
        $conditions = [];
        $params = [];

        if ($search) {
            $conditions[] = "(titulo LIKE :search OR genero LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($order_by === 'titulo') {
            $query .= " ORDER BY titulo";
        } elseif ($order_by === 'autor') {
            $query .= " ORDER BY autor";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    public function lerPerfUsu($idlivro)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idlivro = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idlivro]);
        return $stmt;
    }

    public function lerPoridlivro($idlivro)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idlivro = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idlivro]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function atualizar($idlivro, $titulo, $autor, $genero)
    {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, autor = ?, genero = ? WHERE idlivro = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$titulo, $autor, $genero, $idlivro]);
        return $stmt;
    }
    public function deletarLivro($idlivro)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE idlivro = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idlivro]);
        return $stmt;
    }
}