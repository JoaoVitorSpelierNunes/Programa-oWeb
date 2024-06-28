<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Noticia.php';
/* Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['usuario_id'])) {
    header('Location: portal.php');
    exit();
    }else{
    header('Location: login.php');
    }}
$usuario = new Usuario($db);
$noticia = new Noticia($db);
// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];

    $noticia->deletar($id);
    header('Location: portal.php');
    exit();
}

$dados = $noticia->ler();
$dadosT = $noticia->ler();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <link rel="stylesheet" href="./style/style.css">
    
    
    
</head>

<body>
    
    <header>
    <span onclick="openNav()"><img id="list" src="./img/list.svg" alt="list"></span>
    <h1>Dispatch</h1>
    <form method="POST">
    <button type="submit">Entrar</button>
    </form>
    
    </header>
    
    <br>
    

    <script>function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}</script>
    <div id="mySidenav" class="sidenav"><?php while ($teste = $dadosT->fetch(PDO::FETCH_ASSOC)) : ?>
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#<?php echo $teste['titulo']; ?>"><?php echo $teste['titulo']; ?></a>
  <?php endwhile; ?>
</div>


    <div class=""><?php while ($teste = $dadosT->fetch(PDO::FETCH_ASSOC)) : ?>
        <a href="#<?php echo $teste['titulo']; ?>"><?php echo $teste['titulo']; ?></a>    
        
        
        <?php endwhile; ?></div>
    <div class="main" id="main"></div>
    <div class="feed">
    <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <div class="noticia" id="<?php echo $row['titulo']; ?>">
                <h2><?php echo $row['titulo']; ?></h2>
                <p><?php echo $row['noticia']; ?></p><br><br>
                <h3>Escrito por <?php echo $row['nome']; ?></h3>
                <h3>Data:  <?php echo $row['data']; ?></h3>
            </div><br><br>
        <?php endwhile; ?>
        
    </div>
</body>

</html>