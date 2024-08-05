<?php
include_once "./configuracoes/conexao.php";
include_once "./configuracoes/constante.php";
include_once "./funcoes/funcoes.php";

$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$nome = isset($Dados['nome_usuario']) ? addslashes($Dados['nome_usuario']) : '';
$cpf = isset($Dados['cpf_usuario']) ? addslashes($Dados['cpf_usuario']) : '';
$id = isset($Dados['id']) ? addslashes($Dados['id']) : '';
$ativo = isset($Dados['ativo_usuario']) ? addslashes($Dados['ativo_usuario']) : '';

$retornoInsert = editUsuario2($nome, $cpf, $id, $ativo);

if ($retornoInsert > 0) {
    echo json_encode(['success' => true, 'message' => "Deu Certo!"], JSON_THROW_ON_ERROR);
} else {
    echo json_encode(['success' => false, 'message' => "Deu Erro! Error Bd"], JSON_THROW_ON_ERROR);
}