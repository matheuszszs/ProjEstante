<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Livro.php';
include_once './classes/Comentario.php';

$livro = new Livro($db);

$comentario = new Comentario($db);

$dadosLivro = $livro->lerPoridlivro($_GET['id']);

$jaComentou = false;
$idComentarioUsuario = null;

$dadosComentario = $comentario->lerPorIdliv($_GET['id']);

foreach($dadosComentario as $item){
    if($item['idusu'] == $_SESSION['usuario_id']){
        $jaComentou = true;
        $idComentarioUsuario = $item['idcoment'];
}
}
$dadosComentario = $comentario->lerPorIdliv($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoRegis']) && !$jaComentou) {
    $comentarios = new Comentario($db);
    $comentario = $_POST['comentario'];
    $data = date('Y-m-d');
    $idUsu = $_SESSION['usuario_id'];
    $idLiv = $_GET['id'];
    $titulo = $_POST['titulo'];
    $comentarios->criar($idUsu, $idLiv, $data, $titulo, $comentario);
    header("Refresh:0");
    exit;
}else{
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botaoRegis']) && $jaComentou) {
        $comentarios = new Comentario($db);
        $comentario = $_POST['comentario'];
        $data = date('Y-m-d');
        $idUsu = $_SESSION['usuario_id'];
        $idLiv = $_GET['id'];
        $titulo = $_POST['titulo'];
        $comentarios->atualizar($idUsu, $idLiv, $data, $titulo, $comentario, $idComentarioUsuario);
        header("Refresh:0");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['botaoDelet'])) {
    $comentario->deletar($_POST['botaoDelet']);
    header("Refresh:0");
    exit;
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

    <h3><?php echo htmlspecialchars($dadosLivro['titulo']) ?></h3>
    <p> <?php echo htmlspecialchars($dadosLivro['autor']) ?></p>
    <span> <?php echo htmlspecialchars($dadosLivro['ano_publicacao']) ?></span>

    <div class="regisComen">
        <form method="POST">
            <label for="titulo">Titulo do comentario: </label>
            <input class="campText" type="text" name="titulo" required> <br><br>
            <label for="comentario">Comentario: </label>
            <input class="campText" type="text" name="comentario" required><br><br>
            <div class="botoes">
                <input class="botao" type="submit" name="botaoRegis" value="Adicionar">
            </div>
        </form>
    </div>

    <?php while ($comentario = $dadosComentario->fetch(PDO::FETCH_ASSOC)): ?>
        <li>
            <h1> user <?php echo htmlspecialchars($comentario['idusu']) ?></h1>
            <h2>titulo:<?php echo htmlspecialchars($comentario['titulo']) ?></h2>
            <p> <?php echo htmlspecialchars($comentario['comentario']) ?></p>
            <?php if ($comentario['idusu'] == $_SESSION['usuario_id']): ?>
                <form method="post">
                    <button type="submit" name="botaoDelet" value="<?php echo $comentario['idcoment']; ?>">x</button>
                </form>
            <?php endif; ?>
        </li>
    <?php endwhile; ?>

</body>

</html>