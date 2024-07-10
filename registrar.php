<?php
include_once './config/config.php';
include_once './classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $usuario->criar($nome, $fone, $email, $senha);
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./registrar.css">
    <title>Adicionar Usuário</title>
</head>

<body>

    <a href="login.php"><button class="voltar">Voltar</button></a>

    <div class="box">
        <div class="titulo">
            <h1>Registre-se</h1>
        </div>

        <div class="cadastro">
            <form method="POST">
                <label for="nome">Nome: </label>
                <input class="campText" type="text" name="nome" required> <br><br>
                <label for="fone">Fone: </label>
                <input class="campText" type="text" name="fone" required><br><br>
                <label for="email">Email: </label>
                <input class="campText" type="email" name="email" required><br><br>
                <label for="senha">Senha: </label>
                <input class="campText" type="password" name="senha" required><br><br>
                <div class="botoes">
                    <input class="botao" type="submit" value="Adicionar">
                </div>
            </form>


        </div>

    </div>
</body>

</html>