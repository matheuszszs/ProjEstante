<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

$logged_in = isset($_SESSION['usuario_id']);
$adm = $_SESSION['usuario_adm'];

include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Livro.php';

$livro = new Livro($db);

//Processar exlusão da notícia
if(isset($_GET['idlivro'])){
        $idlivro = $_GET['idlivro'];
        $livro->deletarLivro($idlivro);
        header('Location: index.php');
        exit();
    }
// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados das noticias com filtros
 $dados = $livro->ler($search, $order_by);

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

    <a href="editar.php"><button class="botao">Editar Perfil</button></a>
    <a href="deletar.php"><button class="botao">Excluir Perfil</button></a>
    <a href="portal.php"><button class="botao">Logout</button></a>
    <?php if ($logged_in && $adm == 1): ?>
        <a href="regisLivro.php"><button class="botao">Adicionar um Livro</button></a>
    <?php endif; ?>

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
                        <a href="verLivro.php?id=<?php echo $livro['idlivro']; ?>"><button class="botao">Ver</button></a>
                        <?php if ($logged_in && $adm == 1): ?>
                            <a href="deletarLivro.php?id=<?php echo $livro['idlivro']; ?>"><button class="botao">Excluir Livro</button></a>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

    </div>


</body>

</html>