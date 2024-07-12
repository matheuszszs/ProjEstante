<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);

$usuario->deletar($_SESSION['usuario_id']);
header('Location: index.php');
exit();

?>