<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Livro.php';

$livro = new Livro($db);

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados das noticias com filtros
$dados = $livro->ler($search, $order_by);

// Função para adicionar um produto ao carrinho
function addALista($idlivro, $titulo, $autor, $ano_publicacao, $genero)
{
    if (!isset($_SESSION['lista'])) {
        $_SESSION['lista'] = array();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <title>index</title>
</head>

<body>

    <a href="login.php"><button class="botao">Login</button></a>

    <div class="box">
        <div class="titulo">
            <h1>Página Inicial</h1>
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