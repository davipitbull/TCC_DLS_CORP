<?php
include_once "./configuracoes/conexao.php";
include_once "./configuracoes/constante.php";
include_once "./funcoes/funcoes.php";
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css"
          &gt;>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body style="background-color: #191919">
<div class="container">
    <div class="login-item">
        <div class="form form-login">
            <div class="form-field">
                <i class="mdi mdi-account"></i>
                <input id="email" type="text" class="form-input placee" autocomplete="off" placeholder="Email"
                       required="">
            </div>

            <div class="form-field">
                <i class="mdi mdi-lock" id="iconeOlho" onclick="mostrarsenha();"></i>
                <input id="senha" type="password" class="form-input placee" placeholder="Senha" maxlength="8" autocomplete="off" required="">
            </div>
            <div class="form-field d-grid gap-2 ">
                <button type="button" id="BotaoLogin" onclick="fazerLogin();">
                    Entrar
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="./funcoes/login.js"></script>
<script src="./funcoes/alerta.js"></script>
</body>
</html>
