<?php
//chamando uma vez a conexão no php e sql
require_once "../_conexaoPHP/conexao.php";

//inicia e apresenta a variavel de sessão 
session_start();
$mensagem = "";

if (!isset($_SESSION["user_portal"])) {
    $mensagem_login = "";
} else {
    $usuario = $_SESSION["user_portal"];
    $consulta = "SELECT nome_completo FROM Usuarios WHERE id = {$usuario}";
    $saudacao = mysqli_query($conecta, $consulta);
    $saudacao_login = mysqli_fetch_assoc($saudacao);
    $nome = $saudacao_login['nome_completo'];
    $mensagem_login = "você já conectou a sua conta " . "($nome)";
}
//condições do fomulario via POST
if (isset($_POST["email"]) && isset($_POST['senha'])) {
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
                        <h1 class="logo1">Saúde+</h1>
                            
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

    

    <?php
    mysqli_close($conecta);
    ?>
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