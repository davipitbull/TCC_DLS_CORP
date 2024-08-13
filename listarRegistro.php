<?php
include_once "./configuracoes/conexao.php";
include_once "./configuracoes/constante.php";
include_once "./funcoes/funcoes.php";

// Função para listar registros com parâmetros opcionais
// Função para listar registros com parâmetros opcionais
function listarGeralJoin2($campos, $tabela, $joins = '', $condicoes = '', $offset = 0, $limite = 10)
{
    $conn = conectar();

    if ($conn === null) {
        return false; // Retorna falso se não conseguiu conectar
    }

    try {
        $sql = "SELECT $campos FROM $tabela $joins";
        if (!empty($condicoes)) {
            $sql .= " WHERE $condicoes";
        }
        $sql .= " ORDER BY registro.idregistro DESC"; // Ordena de forma decrescente
        $sql .= " LIMIT $offset, $limite";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);
            $conn = null;
            return $results;
        } else {
            $conn = null;
            return [];
        }
    } catch (PDOException $e) {
        $conn = null;
        echo 'Exception -> ' . $e->getMessage();
        return false;
    }
}


// Função para contar registros com parâmetros opcionais
function contarGeralJoin2($tabela, $joins = '', $condicoes = '')
{
    $conn = conectar();

    if ($conn === null) {
        return 0; // Retorna 0 se não conseguiu conectar
    }

    try {
        $sql = "SELECT COUNT(*) as total FROM $tabela $joins";
        if (!empty($condicoes)) {
            $sql .= " WHERE $condicoes";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $conn = null;
        return $result->total;
    } catch (PDOException $e) {
        $conn = null;
        echo 'Exception -> ' . $e->getMessage();
        return 0;
    }
}

$pesquisa_data_inicio = $_POST['pesquisa_data_inicio'] ?? '';
$pesquisa_data_fim = $_POST['pesquisa_data_fim'] ?? '';
$pesquisa_cpf = $_POST['pesquisa_cpf'] ?? '';
$pesquisa_nome = $_POST['pesquisa_nome'] ?? '';

$condicoes = [];
if (!empty($pesquisa_data_inicio)) {
    $condicoes[] = "registro.data >= '$pesquisa_data_inicio'";
}
if (!empty($pesquisa_data_fim)) {
    $condicoes[] = "registro.data <= '$pesquisa_data_fim'";
}
if (!empty($pesquisa_cpf)) {
    $condicoes[] = "usuario.cpf = '$pesquisa_cpf'";
}
if (!empty($pesquisa_nome)) {
    $condicoes[] = "usuario.nomeUsuario LIKE '%$pesquisa_nome%'";
}

$condicoes_sql = implode(' AND ', $condicoes);

// Defina o número de registros por página
$registros_por_pagina = 10;

// Obtenha a página atual a partir da URL ou do formulário (se não houver, padrão para a página 1)
$pagina_atual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : (isset($_POST['pagina']) ? (int) $_POST['pagina'] : 1);
$offset = ($pagina_atual - 1) * $registros_por_pagina;

// Obtenha o total de registros
$total_registros = contarGeralJoin2('registro', 'INNER JOIN usuario ON registro.idusuario = usuario.idusuario', $condicoes_sql);
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Obtenha os registros para a página atual
$listarRegistro = listarGeralJoin2('registro.idregistro, registro.data, registro.foto, usuario.nomeUsuario, usuario.cpf', 'registro', 'INNER JOIN usuario ON registro.idusuario = usuario.idusuario', $condicoes_sql, $offset, $registros_por_pagina);
?>


<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/btncad.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/tabela.css">
    <link rel="stylesheet" href="./css/btngp.css">
    <link rel="stylesheet" href="./css/pesquisa.css">

    <title>Listar Registros</title>
</head>

<body>
    <div class="welcome mb-5">
        <div class="content rounded-3 p-3">
            <h1 class="fs-3" style="font-family: 'Segoe UI Light',sans-serif">Este é o Menu de Registros!</h1>
            <p class="mb-0" style="font-family: 'Segoe UI Light',sans-serif">Abaixo Encontra-se a Tabela Geral.</p>
        </div>
    </div>

    <form method="post" name="frmpesquisaregistro" id="frmpesquisaregistro" action="dashboard.php?page=registro">
        <input type="hidden" name="pagina" value="1">
        <div class="row mb-4" style="margin-left: 17%">
            <div class="col-md-2">
                <div class="form-group has-search">
                    <label for="pesquisa_data_inicio" style="font-family: 'Segoe UI Light',sans-serif;margin-left: 30%" class="text-white">Data Inicial:</label>
                    <input type="date" name="pesquisa_data_inicio" style="font-family: 'Segoe UI Light',sans-serif" id="pesquisa_data_inicio" class="form-control rounded-5 formedit placer">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group has-search">
                    <label for="pesquisa_data_fim" style="font-family: 'Segoe UI Light',sans-serif;margin-left: 30%" class="text-white">Data Final:</label>
                    <input type="date" name="pesquisa_data_fim" style="font-family: 'Segoe UI Light',sans-serif" id="pesquisa_data_fim" class="form-control rounded-5 formedit placer">
                </div>
            </div>
            <div class="col-md-2 mt-4">
                <div class="form-group has-search">
                    <input type="text" id="pesquisa_cpf" name="pesquisa_cpf" onkeydown="fMasc(this, mCPF);" autocomplete="off" maxlength="14" class="form-control rounded-5 formedit placer cpf_usuario" placeholder="Pesquise Pelo CPF...">
                </div>
            </div>
            <div class="col-md-2 mt-4">
                <div class="form-group has-search">
                    <input type="text" id="pesquisa_nome" name="pesquisa_nome" autocomplete="off" class="form-control rounded-5 formedit placer" placeholder="Pesquise Pelo Nome...">
                </div>
            </div>
            <div class="col-md-2 mt-4">
                <button type="submit" class="btnn mb-2 bg-secondary rounded-5" style="margin-bottom: 20px">
                    <div class="sign">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>Pesquisar</title>
                            <path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                        </svg>
                    </div>
                    <div class="text" style="font-family: 'Segoe UI Light',sans-serif">Pesquisar</div>
                </button>
            </div>
        </div>
    </form>


    <table class="container rounded-5">
        <thead>
            <tr class="text-white" style="font-family: 'Segoe UI Light',sans-serif">
                <th scope="col" width="5%">#</th>
                <th scope="col" width="10%">Data</th>
                <th scope="col" width="10%">Usuário</th>
                <th scope="col" width="10%">CPF</th>
                <th scope="col" width="10%">Foto</th>
                <th scope="col" width="10%">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($listarRegistro) {
                foreach ($listarRegistro as $registro) {
                    $idregistro = $registro->idregistro;
                    $dataregistro = $registro->data;
                    $fotoregistro = $registro->foto;
                    $nomeusuario = $registro->nomeUsuario;
                    $cpfusuario = $registro->cpf;

                    $tipoFoto = "image/png";
            ?>
                    <tr class="text-white" style="font-family: 'Segoe UI Light',sans-serif">
                        <td><?php echo htmlspecialchars($idregistro); ?></td>
                        <td><?php echo htmlspecialchars($dataregistro); ?></td>
                        <td><?php echo htmlspecialchars($nomeusuario); ?></td>
                        <td><?php echo htmlspecialchars($cpfusuario); ?></td>
                        <td>
                            <?php if ($fotoregistro != null) : ?>
                                <img src="data:<?php echo $tipoFoto ?>;base64,<?php echo base64_encode($fotoregistro) ?>" width="100" height="100" title="<?php echo htmlspecialchars($idregistro); ?>" alt="<?php echo htmlspecialchars($idregistro); ?>">
                            <?php else : ?>
                                Sem Foto
                            <?php endif; ?>
                        </td>
                        <td>
                            <button onclick="abrirModalJsVerMais('<?php echo htmlspecialchars($idregistro); ?>','id','ModalVerMais<?php echo htmlspecialchars($idregistro); ?>','A')" class="Btngp bg-warning">
                                <div class="sign">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <title>Ver Mais Dados</title>
                                        <path d="M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C12.36,19.5 12.72,19.5 13.08,19.45C13.03,19.13 13,18.82 13,18.5C13,17.94 13.08,17.38 13.24,16.84C12.83,16.94 12.42,17 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12C17,12.29 16.97,12.59 16.92,12.88C17.58,12.63 18.29,12.5 19,12.5C20.17,12.5 21.31,12.84 22.29,13.5C22.56,13 22.8,12.5 23,12C21.27,7.61 17,4.5 12,4.5M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M18,14.5V17.5H15V19.5H18V22.5H20V19.5H23V17.5H20V14.5H18Z" />
                                    </svg>
                                </div>
                                <div class="text" style="font-family: 'Segoe UI Light',sans-serif">Ver Mais</div>
                            </button>
                            <div class="modal fade" style="background-color: #313348" id="ModalVerMais<?php echo htmlspecialchars($idregistro); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg rounded-5  modal-dialog-centered">
                                    <div class="modal-content rounded-5 ">
                                        <div class="modal-body rounded-5" style="background-color: #252636">
                                            <?php if ($fotoregistro != null) : ?>
                                                <img style="margin-right: 25%;width: 100%" src="data:<?php echo $tipoFoto ?>;base64,<?php echo base64_encode($fotoregistro) ?>" alt="<?php echo htmlspecialchars($idregistro); ?>" title="<?php echo htmlspecialchars($idregistro); ?>">
                                            <?php else : ?>
                                                Sem Foto
                                            <?php endif; ?>
                                            <input type="hidden" id="id_registro" name="id_registro">
                                            <div class="mb-3">
                                                <label for="id_regoistro" class="form-label">ID</label>
                                                <input type="text" class="form-control formvermais rounded-5" id="id_regoistro" name="id_regoistro" value="<?php echo htmlspecialchars($idregistro); ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="data_registro" class="form-label">Data</label>
                                                <input type="text" class="form-control formvermais rounded-5" id="data_registro" name="data_registro" value="<?php echo htmlspecialchars($dataregistro); ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nome_usuario" class="form-label">Nome do Usuário</label>
                                                <input type="text" class="form-control formvermais rounded-5" id="nome_usuario" name="nome_usuario" value="<?php echo htmlspecialchars($nomeusuario); ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cpf_usuario" class="form-label">CPF do Usuário</label>
                                                <input type="text" class="form-control formvermais rounded-5" id="cpf_usuario" name="cpf_usuario" value="<?php echo htmlspecialchars($cpfusuario); ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <th scope="row" colspan="6" class="text-center text-white">Dados Não Encontrados!</th>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <nav aria-label="Navegação de páginas" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($pagina_atual > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="dashboard.php?page=registro&pagina=<?php echo $pagina_atual - 1; ?>&pesquisa_data_inicio=<?php echo urlencode($pesquisa_data_inicio); ?>&pesquisa_data_fim=<?php echo urlencode($pesquisa_data_fim); ?>&pesquisa_cpf=<?php echo urlencode($pesquisa_cpf); ?>&pesquisa_nome=<?php echo urlencode($pesquisa_nome); ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($pagina_atual > 6) : ?>
                <li class="page-item">
                    <a class="page-link" href="dashboard.php?page=registro&pagina=1&pesquisa_data_inicio=<?php echo urlencode($pesquisa_data_inicio); ?>&pesquisa_data_fim=<?php echo urlencode($pesquisa_data_fim); ?>&pesquisa_cpf=<?php echo urlencode($pesquisa_cpf); ?>&pesquisa_nome=<?php echo urlencode($pesquisa_nome); ?>">1</a>
                </li>
                <li class="page-item"><span class="page-link">...</span></li>
            <?php endif; ?>

            <?php for ($i = max(1, $pagina_atual - 5); $i <= min($pagina_atual + 5, $total_paginas); $i++) : ?>
                <li class="page-item <?php if ($i == $pagina_atual) echo 'active'; ?>">
                    <a class="page-link" href="dashboard.php?page=registro&pagina=<?php echo $i; ?>&pesquisa_data_inicio=<?php echo urlencode($pesquisa_data_inicio); ?>&pesquisa_data_fim=<?php echo urlencode($pesquisa_data_fim); ?>&pesquisa_cpf=<?php echo urlencode($pesquisa_cpf); ?>&pesquisa_nome=<?php echo urlencode($pesquisa_nome); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($pagina_atual < $total_paginas - 5) : ?>
                <li class="page-item"><span class="page-link">...</span></li>
                <li class="page-item">
                    <a class="page-link" href="dashboard.php?page=registro&pagina=<?php echo $total_paginas; ?>&pesquisa_data_inicio=<?php echo urlencode($pesquisa_data_inicio); ?>&pesquisa_data_fim=<?php echo urlencode($pesquisa_data_fim); ?>&pesquisa_cpf=<?php echo urlencode($pesquisa_cpf); ?>&pesquisa_nome=<?php echo urlencode($pesquisa_nome); ?>"><?php echo $total_paginas; ?></a>
                </li>
            <?php endif; ?>

            <?php if ($pagina_atual < $total_paginas) : ?>
                <li class="page-item">
                    <a class="page-link" href="dashboard.php?page=registro&pagina=<?php echo $pagina_atual + 1; ?>&pesquisa_data_inicio=<?php echo urlencode($pesquisa_data_inicio); ?>&pesquisa_data_fim=<?php echo urlencode($pesquisa_data_fim); ?>&pesquisa_cpf=<?php echo urlencode($pesquisa_cpf); ?>&pesquisa_nome=<?php echo urlencode($pesquisa_nome); ?>" aria-label="Próximo">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>



    <script src="./funcoes/funcoes.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataInicio = document.getElementById('pesquisa_data_inicio');
            const dataFim = document.getElementById('pesquisa_data_fim');

            dataInicio.addEventListener('change', validarDatas);
            dataFim.addEventListener('change', validarDatas);

            function validarDatas() {
                const dataInicioValue = new Date(dataInicio.value);
                const dataFimValue = new Date(dataFim.value);
                const hoje = new Date();

                if (dataInicioValue && dataFimValue) {
                    if (dataInicioValue > dataFimValue) {
                        alert('A data inicial não pode ser maior que a data final.');
                        dataInicio.value = '';
                        dataFim.value = '';
                    } else if (dataInicioValue > hoje) {
                        alert('A data inicial não pode ser uma data futura.');
                        dataInicio.value = '';
                    } else if (dataFimValue > hoje) {
                        alert('A data final não pode ser uma data futura.');
                        dataFim.value = '';
                    }
                } else if (dataInicioValue > hoje) {
                    alert('A data inicial não pode ser uma data futura.');
                    dataInicio.value = '';
                } else if (dataFimValue > hoje) {
                    alert('A data final não pode ser uma data futura.');
                    dataFim.value = '';
                }
            }
        });
    </script>


</body>

</html>