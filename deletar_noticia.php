<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Noticia.php';
$usuario = new Usuario($db);
$noticia = new Noticia($db);
if (isset($_GET['idnot'])) {
    $idnot = $_GET['idnot'];
    $noticia->deletar($idnot);
    header('Location: portal.php');
    exit();
}
