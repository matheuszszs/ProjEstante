<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once './config/config.php';
include_once './classes/Usuario.php';

//Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$usuario = new Usuario($db);


//Processar exlusão do usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: crudUsuario.php');
    exit();
}

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados dos usuários com filtros
$dados = $usuario->ler($search, $order_by);


//Obtem dados do usuário logado
$dados_Usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_Usuario['nome'];

//Obter dados dos usuários
$dados = $usuario->ler($search, $order_by);
//Função para determinar saudação
function saudacao()
{
    $hora = date("H");
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia!";
    } else if ($hora >= 12 && $hora < 18) {
        return "Boa tarde!";
    } else {
        return "Boa noite!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./crudUsuario.css">
    <title>Portal</title>
</head>

<body>

    <a href="deletar.php?id=<?php echo $row['id']; ?>"><button>Deletar</button></a>
    <a href="login.php"><button class="botao">Logout</button></a>

    <div class="box">
        <div class="titulo">
            <h1>Bem Vindo ao Portal de Notícias</h1>
        </div>

        <div class="container">
            <ul class="livroLista">
                <?php while ($livro = $dados->fetch(PDO::FETCH_ASSOC)): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($livro['titulo']) ?></h3>
                        <p> <?php echo htmlspecialchars($livro['autor']) ?></p>
                        <span> <?php echo htmlspecialchars($livro['ano_publicacao']) ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>

</html>