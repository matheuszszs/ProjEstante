<?php 
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }

    include_once './config/config.php';
    include_once './classes/Livro.php';

    $livro = new Livro($db);
    if(isset($_GET['idnot'])){
        $idlivro = $_GET['idlivro'];
        $livro->deletarLivro($idlivro);
        header('Location: portal.php');
        exit();
    }
?>