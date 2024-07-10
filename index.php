<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Livro.php';

$l = new Livro($db);

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados das noticias com filtros
$dados = $l->ler($search, $order_by);

//Obter dados das noticias
//$dados = $noticias->ler($search, $order_by);
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

    <a href="login.php"><button class="botao">Login.</button></a>

    <div class="box">
        <div class="titulo">
            <h1>Portal de Notícias.</h1>
        </div>

        <div class="noticiasContainer">
            <ul class="noticiaLista">
                <?php while ($noticia = $dados->fetch(PDO::FETCH_ASSOC)): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($noticia['titulo']) ?></h3>
                        <p> <?php echo htmlspecialchars($noticia['noticia']) ?></p>
                        <span> <?php echo htmlspecialchars($noticia['data']) ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

</body>

</html>