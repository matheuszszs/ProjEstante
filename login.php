<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        if ($dados_Usuario = $usuario->login($email, $senha)) {
            $_SESSION['usuario_id'] = $dados_Usuario['id'];
            header('location:portal.php');
            exit();
        } else {
            $mensagem_erro = "Credenciais Inválidas!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <title>Estante Virtual</title>
</head>

<body>
    <div class="box">
        <div class="titulo">
            <h1>Login</h1>
        </div>

        <div class="cadastro">
            <form method="POST">
                <label for="email">Email: </label>
                <input class="textCamp" type="email" name="email" required><br><br>
                <label for="senha">Senha: </label>
                <input class="textCamp" type="password" name="senha" required><br><br>
                <input class="botao" type="submit" name="login" value="Entrar">
            </form>

            <div class="mensagem">
                <?php
                if (isset($mensagem_erro))
                    echo '<p>' . $mensagem_erro . '</p>';
                ?>
            </div>
        </div>

        <div class="recad">
            <p>Não tem uma conta? <a href="./registrar.php">Registre-se</a></p>
            <p><a href="./solicitar_recuperacao.php">Esqueceu a senha?</a></p>
        </div>


    </div>

</body>

</html>