<?php
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'Farmacia';
$conecta = mysqli_connect($servidor, $usuario, $senha, $banco);

if (mysqli_connect_errno()) {
    die('conexão falha:' . mysqli_connect_errno());
}

?>