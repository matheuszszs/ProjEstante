<?php 
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }

    include_once './config/config.php';
    include_once './classes/Livro.php';
    include_once './classes/Usuario.php';

    $livro = new Livro($db);

  
    if(isset($_GET['id'])){
        $idlivro = $_GET['id'];
        $livro->deletarLivro($idlivro);
        header('Location: index.php');
        exit();
    }
?>