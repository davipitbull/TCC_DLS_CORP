<?php
include_once "./configuracoes/constante.php";
include_once "./configuracoes/conexao.php";
include_once "./funcoes/funcoes.php";

$idadm = $_SESSION['idadm'];
$nomeadm = $_SESSION['nome'];
if ($idadm and $nomeadm) {
} else {
    session_destroy();
}
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'main';

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/btnlogout.css">
    <link rel="stylesheet" href="./css/style.css">

</head>

<body style="background-color: #191919">
<div class="sidebar">
        <li class=" hoverzin mb-3 ms-3" style="font-family: 'Segoe UI Light',sans-serif;list-style-type: none">
            <i class="mdi mdi-text-box-edit " style="color: gray"></i><a class="text-white" style=" text-decoration: none" href="?page=registro">Registro</a>
        </li>
        <li  class=" ms-3 hoverzin" style="font-family: 'Segoe UI Light',sans-serif;list-style-type: none;">
            <i class="mdi mdi-account-hard-hat " style="color: gray" ></i><a class="text-white" style=" text-decoration: none" href="?page=usuario">Usuários</a>
        </li>
</div>

    <section id="wrapper">
        <nav style="background-color: #3a3b4a;margin-left: 10%" class=" text-white navbar navbar-expand-md cornav">
            <div class="container-fluid mx-2">
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" style="display: flex;align-items: start; justify-content: start;width: 20%" data-bs-toggle="collapse" data-bs-target="#toggle-navbar" aria-controls="toggle-navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="mdi mdi-plus-box"></i>
                    </button>
                    <a class="navbar-brand text-white" style="font-family: 'Segoe UI Light',sans-serif;">Seja Bem-Vindo, <?php echo $nomeadm ?>!</a>
                </div>
                <div class="collapse navbar-collapse" id="toggle-navbar">
                    <ul class="navbar-nav ms-auto">
                        <button style="background-color: red" onclick="sair();" class="Btn">

                            <div class="sign"><svg viewBox="0 0 512 512">
                                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                                </svg></div>

                            <div class="text" style="font-family: 'Segoe UI Light',sans-serif">Sair</div>
                        </button>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="p-4">
            <div id="carregaConteudo">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'main';

                switch ($page) {
                    case 'usuario':
                        include "listarUsuario.php";
                        break;
                    case 'registro':
                        include "listarRegistro.php";
                        break;

                        // Adicione mais casos conforme necessário

                    default:
                        include "bemvindo.php";
                        break;
                }
                ?>

            </div>
        </div>



        <script src="./funcoes/nav.js"></script>
        <script src="./funcoes/funcoes.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>