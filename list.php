<?php
require 'db.php';

$stmt = $pdo->query('SELECT * FROM imagens');
$imagens = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Imagens</title>
</head>
<body>
    <h1>Lista de Imagens</h1>
    <a href="index.php">Voltar</a><br><br>
    <?php if (count($imagens) > 0): ?>
        <ul>
            <?php foreach ($imagens as $imagem): ?>
                <li>
                    <strong><?php echo htmlspecialchars($imagem['nome']); ?></strong><br>
                    <img src="<?php echo htmlspecialchars($imagem['caminho']); ?>" alt="<?php echo htmlspecialchars($imagem['nome']); ?>" width="200"><br>
                    <a href="edit.php?id=<?php echo $imagem['id']; ?>">Editar</a> | 
                    <a href="delete.php?id=<?php echo $imagem['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta imagem?');">Excluir</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhuma imagem encontrada.</p>
    <?php endif; ?>
</body>
</html>
