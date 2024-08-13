<?php
include_once "./configuracoes/constante.php";
include_once "./configuracoes/conexao.php";
include_once "./funcoes/funcoes.php";

$idadm = $_SESSION['idadm'];
$nomeadm = $_SESSION['nome'];

if (!$idadm || !$nomeadm) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$currentPage = isset($_GET['page']) ? $_GET['page'] : 'main';
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="user-welcome">Seja Bem-Vindo, <?php echo $nomeadm; ?>!</div>
        <button onclick="sair();" class="logout-button">Sair</button>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="?page=registro">Registro</a></li>
            <li><a href="?page=usuario">Usuários</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div id="content">
        <?php
        switch ($currentPage) {
            case 'usuario':
                include "listarUsuario.php";
                break;
            case 'registro':
                include "listarRegistro.php";
                break;
            default:
                include "bemvindo.php";
                break;
        }
        ?>
    </div>

    <script src="./funcoes/funcoes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>