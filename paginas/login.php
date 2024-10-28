<?php
//chamando uma vez a conexão no php e sql
require_once("../_conexaoPHP/conexao.php");

//inicia e apresenta a variavel de sessão 
session_start();
$mensagem = "";

if(!isset($_SESSION["user_portal"])){
    $mensagem_login="";
}else{
    $usuario=$_SESSION["user_portal"];
    $consulta="SELECT nome FROM Usuarios
                WHERE id = {$usuario}";
    $saudacao = mysqli_query($conecta,$consulta);
    $saudacao_login = mysqli_fetch_assoc($saudacao);
    $nome = $saudacao_login['nome'];
    $mensagem_login="você já conectou a sua conta ". "($nome)" ;
}
//condições do fomulario via POST
if (isset($_POST["usuario"])) {
    $usuario  =  $_POST['usuario'];
    $email    =  $_POST['email'];
    $senha    =  $_POST['senha'];

    //escreve a consulta
    $login = "SELECT *";
    $login .= " FROM Usuarios ";

    //ele compara os valores inseridos do imput do login
    $login .= " WHERE username = '{$usuario}' and  senha = '{$senha}' and email = '{$email}' ";

    //conecta a consulta
    $acesso = mysqli_query($conecta, $login);

    if (!$acesso) {
        die("Falha na consulta ao Banco no acesso.");
    }

    $informacao = mysqli_fetch_assoc($acesso);

    if (empty($informacao)) {
        $mensagem = "Login Sem Sucesso :( .";
    } else {
        $_SESSION['user_portal'] = $informacao['id'];
        header('location:produtos.php');
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <!-- LINKS -->
    <link rel="stylesheet" href="../_css/login.css">
    <title>Login</title>
</head>

<body>
    <header class="cabeçario"></header>
    <main class="principal">

        <header class="cabecario_login">
            <h1 class="titulo">Login</h1>
            <h1 class="logo">Saude+</h1>
        </header>

        <form class="formulario" action="login.php" method="post">
            <div class="campo">
                <label for="usuario">
                    <p class="nome_campo">usuario</p>
                </label>
                <input type="text" name="usuario" placeholder="insira aqui o usuario">
            </div>

            <div class="campo">
                <label for="email">
                    <p class="nome_campo">email</p>
                </label>
                <input type="email" name="email" placeholder="insira aqui a email">
            </div>

            <div class="campo">
                <label for="senha">
                    <p class="nome_campo">senha</p>
                </label>
                <input type="password" name="senha" placeholder="insira aqui a senha">
            </div>
            <div class="botoes">
            <input type="submit" class="botao_login" value="Entrar">
            <a href="../paginas/logout.php" id="logout" class="botao_logout">Logout</a>
            </div>
        </form>
        <p class="mensagem_error" id="mensagemError"><?php if (isset($mensagem)) {
                                                            echo $mensagem;} ?>
        </p>
        <p id="mensagem_login" class="mensagem_login"><?php echo $mensagem_login ?></p>
        
    </main>
    <footer class="rodape">&copy; feito por Davi Miranda</footer>
</body>
<script>
    let mensagemError = document.getElementById("mensagemError");
    if (mensagemError.textContent.trim() === "") {
        mensagemError.style.display = "none";
    }else{
        mensagemError.style.display = "flex";
    }

    let mensagem_logout = document.getElementById("mensagem_login");

    if(mensagem_logout.textContent.trim()==""){
        mensagem_logout.style.display="none";
    }else{
        mensagem_logout.style.display="flex";
    }

</script>

</html>