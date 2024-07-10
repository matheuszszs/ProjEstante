<?php
include_once './config/config.php';
include_once './classes/Livro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livros = new Livro($db);
    $ano_publicacao = $_POST['anoPubli'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $titulo = $_POST['titulo'];
    $livros->criar($titulo, $autor, $genero, $ano_publicacao);
    header('Location: portal.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Livro</title>
</head>

<body>
    <a href="portal.php"><button>Voltar</button></a>

    <div class="box">
        <div class="titulo">
            <h1>Registrar Livro</h1>
        </div>

        <div class="regisLivro">
            <form method="POST">
                <label for="titulo">Titulo: </label>
                <input class="campText" type="text" name="titulo" required> <br><br>
                <label for="autor">Autor: </label>
                <input class="campText" type="text" name="autor" required><br><br>
                <label for="anoPubli">Ano de Publicação: </label>
                <input class="campText" type="text" name="anoPubli" required><br><br>
                <label for="genero">Gênero: </label>
                <select name="genero" id="genero">
                    <option value="Ficção Científica">Ficção Científica</option>
                    <option value="Fantasia">Fantasia</option>
                    <option value="Mistério">Mistério</option>
                    <option value="Suspense Thriller">Suspense/Thriller</option>
                    <option value="Romance">Romance</option>
                    <option value="Histórico">Histórico</option>
                    <option value="Literatura Contemporânea">Literatura Contemporânea</option>
                    <option value="Young Adult">Young Adult (YA)</option>
                    <option value="Terror">Terror</option>
                    <option value="Aventura">Aventura</option>
                    <option value="Biografia Autobiografia">Biografia/Autobiografia</option>
                    <option value="Memórias">Memórias</option>
                    <option value="Literatura Clássica">Literatura Clássica</option>
                    <option value="Ensaios">Ensaios</option>
                    <option value="Literatura Infantil">Literatura Infantil</option>
                </select><br><br>
                <div class="botoes">
                    <input class="botao" type="submit" value="Adicionar">
                </div>
            </form>


        </div>

    </div>
</body>

</html>