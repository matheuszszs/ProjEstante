<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');

    exit();
}

include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $usuario->atualizar($id, $nome, $fone, $email);
    header('Location: crudUsuario.php');
    exit();
}


$row = $usuario->lerPorId($_SESSION['usuario_id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
</head>

<body>
    <h1>Editar Usuário</h1>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="nome">Nome: </label>
        <input type="text" name="nome" value="<?php echo $row['nome'] ?>" required><br><br>

        <label for="fone">Fone: </label>
        <input type="text" name="fone" value="<?php echo $row['fone'] ?>" required><br><br>

        <label for="email">Email: </label>
        <input type="text" name="email" type="email" value="<?php echo $row['email'] ?>" required><br><br>

        <input type="submit" value="Atualizar">
        <input type="text">
    </form>
</body>
</html>