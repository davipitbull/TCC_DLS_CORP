<?php
include_once("./configuracoes/conexao.php");
include_once("./configuracoes/constante.php");
include_once("./funcoes/funcoes.php");

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
// echo json_encode($dados);
$email = $dados['email'];
$senha = $dados['senha'];
$retornoValidar = verificarSenhaCriptografada('*', 'adm', 'email', $email, 'senha', $senha, 'ativo', 'A');

if ($retornoValidar) {
    if ($retornoValidar === 'usuario') {
        echo json_encode(['success' => false, 'message' => "Email Errado! Confira: ($email)"]);
    } else if ($retornoValidar === 'senha') {
        echo json_encode(['success' => false, 'message' => "Senha Errada! Confira: ($senha)"]);
    } else {
        $_SESSION['idadm'] = $retornoValidar->idadm;
        $_SESSION['nome'] = $retornoValidar->nome;
        $nome = $_SESSION['nome'];
        echo json_encode(['success' => true, 'message' => "$nome Fez Login!"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "Erro!"]);
}