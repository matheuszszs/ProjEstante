<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $imagem = $_FILES['imagem'];

    // Verificar se houve erro no upload
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid() . '.' . $extensao;
        $caminhoArquivo = 'uploads/' . $nomeArquivo;

        // Mover o arquivo para a pasta de uploads
        if (move_uploaded_file($imagem['tmp_name'], $caminhoArquivo)) {
            // Salvar o caminho no banco de dados
            $stmt = $pdo->prepare('INSERT INTO imagens (nome, caminho) VALUES (:nome, :caminho)');
            $stmt->execute(['nome' => $nome, 'caminho' => $caminhoArquivo]);

            echo "Imagem carregada com sucesso!";
            echo " <a href='index.php'>Voltar</a><br><br>";
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Erro no upload: " . $imagem['error'];
    }
} else {
    echo "Método de requisição inválido.";
}
?>
