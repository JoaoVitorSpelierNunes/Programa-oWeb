<?php
include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Noticia.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noticia = new Noticia($db);
    $id = $_SESSION['usuario_id'];
    $data = $_POST['data'];
    $titulo = $_POST['titulo'];
    $desc = $_POST['desc'];
    $noticia->criar($id, $data, $titulo, $desc);
    header('Location: portal.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Notícia</title>
    <link rel="stylesheet" href="./style/registrar_noticia.css">
</head>

<body>
    <div class="container">
    <h1>Adicionar Notícia</h1>
    <form method="POST">

        <label for="data">Data:</label>
        <input type="date" name="data" required>
        <br><br>
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>
        <br><br>
        <label for="desc">Descrição:</label><br>
        <textarea name="desc" id="desc" required></textarea>
        <input type="submit" value="Adicionar">
    </form>
    </div>
</body>

</html>