<?php
//chamando uma vez a conexão no php e sql
require_once("../_conexaoPHP/conexao.php");

//inicia e apresenta a variavel de sessão 
session_start();
$mensagem = "";

if (!isset($_SESSION["user_portal"])) {
    $mensagem_login = "";
} else {
    $usuario = $_SESSION["user_portal"];
    $consulta = "SELECT nome FROM Usuarios
                WHERE id = {$usuario}";
    $saudacao = mysqli_query($conecta, $consulta);
    $saudacao_login = mysqli_fetch_assoc($saudacao);
    $nome = $saudacao_login['nome'];
    $mensagem_login = "você já conectou a sua conta " . "($nome)";
}
//condições do fomulario via POST
if (isset($_POST["email"])) {
    $email    =  $_POST['email'];
    $senha    =  $_POST['senha'];

    //escreve a consulta
    $login = "SELECT *";
    $login .= " FROM Usuarios ";

    //ele compara os valores inseridos do imput do login
    $login .= " WHERE email = '{$email}' and senha = '{$senha}'   ";

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
    <title>cadastro</title>
</head>

<body>
    <div class="container">
        <div class="form-imagem">
            <img src="../_fotos/img_login.svg" alt="imagem login">
        </div>
        
        <div class="form">
            <form action="login.php" method="post">
                <div class="form__cabecalho">
                    <div class="titulo">
                        
                        <h1>Login</h1>
                        
                    </div>
                    <div class="logomarca">
                        <h1 class="logo1">Saude+</h1>
                            
                    </div>
                </div>
                    <h2 class="saudacoes">Seja bem vindo(a) novamente.</h2>

                    <div class="input_gruop">
                        <div class="input-box">
                            <label for="email">Email:</label>
                            <input id="email" name="email" type="email" placeholder="insira aqui" required>
                        </div>
                        <div class="input-box">
                            <label for="senha">Senha:</label>
                            <input id="senha" name="senha" type="password" placeholder="insira aqui" required>
                        </div>
                    </div>
                    <div class="botoes">
                        <div class="box-botoes">
                            <input type="submit" value="Entrar">
                        </div>
                        <div class="box-botoes">
                            <a href="logout.php">Sair</a>
                        </div>

                    </div>
                <div class="sign-up__button">
                    <a id="sign-up" href="cadastro.php">cadastrar-se<img src="../_fotos/arrow__forward.svg" alt=""></a>
                </div>
                <p class="mensagem_error" id="mensagemError"><?php if (isset($mensagem)) {echo $mensagem;} ?></p>
                <p id="mensagem_login" class="mensagem_login"><?php echo $mensagem_login ?></p>
            </form>
        </div>
         
    </div>

    

    
</body>
<script>
    let mensagemError = document.getElementById("mensagemError");
    if (mensagemError.textContent.trim() === "") {
        mensagemError.style.display = "none";
    } else {
        mensagemError.style.display = "flex";
    }

    let mensagem_logout = document.getElementById("mensagem_login");

    if (mensagem_logout.textContent.trim() == "") {
        mensagem_logout.style.display = "none";
    } else {
        mensagem_logout.style.display = "flex";
    }
</script>

</html>