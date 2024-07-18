<?php
include_once './config/config.php';
include_once './classes/Livro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livros = new Livro($db);
    $ano_publicacao = $_POST['anoPubli'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $titulo = $_POST['titulo'];
    $imagem = $_FILES['imagem'];

    // Verificar se houve erro no upload
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid() . '.' . $extensao;
        $caminhoArquivo = 'uploads/' . $nomeArquivo;

        // Mover o arquivo para a pasta de uploads
        if (move_uploaded_file($imagem['tmp_name'], $caminhoArquivo)) {
            // Chamar método para criar o livro, passando o caminho da imagem
            $livros->criar($titulo, $autor, $genero, $ano_publicacao, $caminhoArquivo);
            echo "Livro registrado com sucesso!";
            echo " <a href='portal.php'>Voltar</a><br><br>";
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Erro no upload: " . $imagem['error'];
    }
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
            <form method="POST" enctype="multipart/form-data">
                <label for="titulo">Titulo: </label>
                <input class="campText" type="text" name="titulo" required> <br><br>
                <label for="autor">Autor: </label>
                <input class="campText" type="text" name="autor" required><br><br>
                <label for="anoPubli">Ano de Publicação: </label>
                <input class="campText" type="number" name="anoPubli" required><br><br>
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
                <label for="imagem">Escolha a imagem:</label>
                <input type="file" name="imagem" id="imagem" required><br><br>
                <div class="botoes">
                    <input class="botao" type="submit" value="Adicionar">
                </div>
            </form>
        </div>
    </div>
</body>

</html>
