<?php
session_start();
//desconfigurar(logout) uma variavel de sessao
unset($_SESSION['user_portal']);
//emcaminhamento para outra pagina
header('location:login.php');
?>