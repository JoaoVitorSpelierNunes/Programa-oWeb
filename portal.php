<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Noticia.php';
// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
$usuario = new Usuario($db);
$noticia = new Noticia($db);
// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];

    $noticia->deletar($id);
    header('Location: portal.php');
    exit();
}
// Obter dados do usuário logado
$dados_noticia = $noticia->lerIdusu($_SESSION['usuario_id']);
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
$autor = $dados_usuario['nome'];
// Obter dados dos usuários
$dados = $noticia->lerIdusu($_SESSION['usuario_id']);
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
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <link rel="stylesheet" href="./style/portal.css">
</head>

<body>
    <header>
        <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
        <nav>
            <a href="registrar.php"><button>Adicionar Usuário</button></a>
            <a href="registrar_noticia.php"><button>Adicionar Notícia</button></a>
            <a href="index.php"><button>Home</button></a>
            <a href="logout.php"><button>Logout</button></a>
        </nav>

    </header>





    <br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Autor</th>
            <th>Data</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['idnot']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['data']; ?></td>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['noticia']; ?></td>
                <td>
                    <a href="editar_noticia.php?idnot=<?php echo $row['idnot'];
                                                        ?>">Editar</a>
                    <a href="deletar_noticia.php?idnot=<?php echo $row['idnot'];
                                                        ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>