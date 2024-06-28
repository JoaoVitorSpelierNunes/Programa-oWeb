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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idnot = $_POST['idnot'];
    $data = $_POST['data'];
    $titulo = $_POST['titulo'];
    $desc = $_POST['desc'];

    $noticia->atualizar($idnot, $data, $titulo, $desc);
    header('Location: portal.php');
    exit();
}
if (isset($_GET['idnot'])) {
    $idnot = $_GET['idnot'];
    $row = $noticia->lerPorId($idnot);

}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Notícia</title>
    <link rel="stylesheet" href="./style/editar_noticia.css">
</head>

<body>
<div class="container">
    <h1>Adicionar Notícia</h1>
    <form method="POST">
        <input type="hidden" name="idnot" value="<?php echo $row['idnot']; ?>">
        <label for="data">Data:</label>
        <input type="date" name="data"  value="<?php echo $row['data']; ?>" required>
        <br><br>
        <label for="titulo">Título:</label>
        <input type="text" name="titulo"  value="<?php echo $row['titulo']; ?>" required>
        <br><br>
        <label for="desc">Descrição:</label><br>
        <textarea name="desc" id="desc" required><?php echo $row['noticia']; ?></textarea>
        <input type="submit" value="Atualizar">
    </form>
</div>
</body>

</html>