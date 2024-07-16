<?php
session_start();

$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$adm = isset($_GET['adm']);


include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Livro.php';
?>