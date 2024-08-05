<?php
$controle = filter_input(INPUT_POST, 'controle', FILTER_SANITIZE_STRING);
if (!empty($controle) && isset($controle)) {

    if ($controle == 'listarRegistro') {
        include_once 'listarRegistro.php';
    } else if ($controle == 'listarUsuario'){
        include_once 'listarUsuario.php';
    } else if ($controle == 'listarObras'){
        include_once 'listarObras.php';
    } else if ($controle == 'bemvindo'){
        include_once 'bemvindo.php';
    } else if ($controle == 'excusuario'){
        include_once 'excusuario.php';
    } else if ($controle == 'alterarusuario'){
        include_once 'alterarusuario.php';
    }
}