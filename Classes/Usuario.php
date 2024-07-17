<?php
class Usuario
{
    private $conn;
    private $table_name = "usuarios";
    


    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function registrar($nome, $fone, $email, $senha, $adm)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, fone, email, senha, adm) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $fone, $email, $hashed_password, $adm]);
        return $stmt;
    }


    public function login($email, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function ler($search = '', $order_by = '') {
        $query = "SELECT * FROM usuarios ";
        $conditions = [];
        $params = [];

        if ($search) {
           $conditions[] = "(nome LIKE :search OR email LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($order_by === 'nome') {
            $query .= " ORDER BY nome";
        } elseif ($order_by === 'fone') {
            $query .= " ORDER BY fone";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    public function lerPerfUsu($id){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function atualizar($id, $nome, $fone, $email)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, fone = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $fone, $email, $id]);
        return $stmt;
    }
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

// Função para excluir o usuário logado
    public function excluirPerfil($id){
        if(is_numeric($id)) {
            $query = "DELETE FROM usuarios WHERE id = $id";
            
            if($this->conn->query($query) === TRUE){
                return true; //Exclusão feita
            } else {
                echo "Erro ao excluir o usuário desejado: " . $this->conn->error;
            }
        } else {
            echo "ID de usuário inválido!";
        }

        return false; //Exclusão falhou
    }

    // Gera um código de verificação e o salva no banco de dados
    public function gerarCodigoVerificacao($email)
    {
        $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
        $query = "UPDATE " . $this->table_name . " SET codigo_verificacao = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigo, $email]);
        return ($stmt->rowCount() > 0) ? $codigo : false;
    }
    // Verifica se o código de verificação é válido
    public function verificarCodigo($codigo)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE codigo_verificacao = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Redefine a senha do usuário e remove o código de verificação
    public function redefinirSenha($codigo, $senha)
    {
        $query = "UPDATE " . $this->table_name . " SET senha = ?, codigo_verificacao = NULL WHERE codigo_verificacao = ?";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$hashed_password, $codigo]);
        return $stmt->rowCount() > 0;
    }

    public function verificaAdm($id){
        $query = "SELECT adm FROM usuarios WHERE id = 1";
        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->FETCH_ASSOC();
            return $row['id'] == 1;
        } else {
            return false;
        }
    }
}


// {
//     $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
//     $stmt = $this->conn->prepare($query);
//     $stmt->execute([$email]);
//     $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
//     if ($usuario && password_verify($senha, $usuario['senha'])) {
//         return $usuario;
//     }
//     return false;
// }