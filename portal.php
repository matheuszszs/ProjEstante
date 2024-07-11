<?php
include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Livro.php';




$livros = new Livro($db);

$usuarios = new Usuario($db);


// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

$dados = $livros->ler($search, $order_by);
// Função para determinar a saudação

function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
</head>

<body>
    <header id="tm-header">
        <div>
            <div>
                <div><i></i></div>
                <h1>LOGOOOOOOOOOOOOO</h1>
            </div>
            <nav id="tm-nav">
                <ul>
                    <a href="login.php"><button>Login</button></a>
                </ul>
            </nav>

            <p>
                Site feito pelo Xiruzinho Yago Ferreira para o projeto final de Programação Web II
            </p>
        </div>
    </header>
    <div>
        <main>
            <!-- Search form -->
            <div>
                <div>
                    <form method="GET">
                        <div>
                    </form>
                </div>

                <div class="container">
                    <ul class="livroLista">
                        <?php while ($livro = $dados->fetch(PDO::FETCH_ASSOC)): ?>
                            <li>
                                <h3><?php echo htmlspecialchars($livro['titulo']) ?></h3>
                                <p> <?php echo htmlspecialchars($livro['autor']) ?></p>
                                <span> <?php echo htmlspecialchars($livro['ano_publicacao']) ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>

        </main>
    </div>
</body>

</html>