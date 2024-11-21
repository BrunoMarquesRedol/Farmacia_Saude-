<?php
// Incluindo o arquivo de conexão
require_once "../_conexaoPHP/conexao.php"; // Certifique-se de que o caminho está correto

// Verifica se o formulário foi enviado e os campos necessários estão definidos
if (isset($_POST['email'], $_POST['nomeCompleto'], $_POST['nomeUsuario'], $_POST['senha'])) {
    // Captura os valores do formulário e evita SQL Injection
    $nomeComp = mysqli_real_escape_string($conecta, $_POST["nomeCompleto"]);
    $nomeUsu  = mysqli_real_escape_string($conecta, $_POST["nomeUsuario"]);
    $email    = mysqli_real_escape_string($conecta, $_POST["email"]);
    $senha    = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Criptografa a senha

    // Insere os dados no banco de dados
    $inserir = "INSERT INTO usuarios (nome_completo, username, email, senha) VALUES ('$nomeComp', '$nomeUsu', '$email', '$senha')";

    // Executa a operação de inserção
    $operacao_inserir = mysqli_query($conecta, $inserir);

    if (!$operacao_inserir) {
        // Mensagem de erro em caso de falha
        die('Falha na inserção de dados: ' . mysqli_error($conecta));
    } else {
        // Consulta os dados do usuário inserido
        $consulta = "SELECT id, nome_completo FROM usuarios WHERE email = '$email'";
        $operacao_consulta = mysqli_query($conecta, $consulta);

        if ($operacao_consulta && mysqli_num_rows($operacao_consulta) > 0) {
            // Armazena os dados do usuário na sessão
            session_start(); // Certifique-se de iniciar a sessão
            $resultado = mysqli_fetch_assoc($operacao_consulta);
            $_SESSION['user_portal'] = $resultado['id']; // Substitua 'id' pelo campo correto

            // Redireciona para a página de produtos
            header("Location: produtos.php");
            exit(); // Finaliza o script após o redirecionamento
        } else {
            // Mensagem de erro em caso de falha na consulta
            die('Erro ao buscar os dados do usuário.');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINK -->
    <link href="../_css/cadastro.css" rel="stylesheet">

    <title>Cadastro</title>
</head>

<body>
    <div class="container">
        <div class="form-imagem">
            <img src="../_fotos/cadastro.svg" alt="Imagem Cadastro">
        </div>
        <div class="form">
            <form action="cadastro.php" method="post">
                <div class="form-cabecalho">
                    <div class="logomarca">
                        <h1 class="logo1">Saude+</h1>
                    </div>
                    <div class="titulo">
                        <h1>Cadastrar-se</h1>
                    </div>
                </div>

                <h2 class="saudacoes">Seja bem-vindo(a), vamos nos cadastrar?</h2>

                <div class="input_group">
                    <div class="input-box">
                        <label for="nomeCompleto">Nome completo:</label>
                        <input type="text" id="nomeCompleto" name="nomeCompleto" required>
                    </div>
                    <div class="input-box">
                        <label for="nomeUsuario">Nome de usuário:</label>
                        <input type="text" id="nomeUsuario" name="nomeUsuario" required>
                    </div>
                    <div class="input-box">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-box">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>
                    <?php if (!empty($mensagem)): ?>
                        <p class="mensagem_error" id="mensagemError"><?php echo htmlspecialchars($mensagem); ?></p>
                    <?php endif; ?>
                </div>
                <div class="botoes">
                    <div class="box-botoes">
                        <input type="submit" value="Cadastrar-se">
                    </div>
                    <div class="box-botoes">
                        <a href="login.php" class="entrar">Entrar <img src="../_fotos/arrow__forward.svg" alt=""></a>
                    </div>
                </div>
                <!-- Exibe mensagem de erro -->



            </form>
        </div>
    </div>

    <?php
    mysqli_close($conecta);
    ?>

</body>

</html>