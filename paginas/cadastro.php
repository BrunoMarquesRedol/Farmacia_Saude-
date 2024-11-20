<?php

?>
<!DOCTYPE html>
<html lang="en">

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
            <img src="../_fotos/cadastro.svg" alt="imagem Cadastro">
        </div>
        <div class="form">
            <form action="cadastro.php" method="post">
                <div class="form-cabecalho">
                    <div class="titulo">
                        <h1>Cadastrar-se</h1>
                    </div>
                    <div class="logomarca">
                        <h1 class="logo1">Saude+</h1>
                    </div>
                </div>

                <h2 class="saudacoes">Seja bem vindo(a),vamos nos cadastrar?</h2>

                <div class="input_gruop">
                    <div class="input-box">
                        <label for="nome">Nome completo:</label>
                        <input type="text" id="nome" required>
                    </div>
                    <div class="input-box">
                        <label for="nome">Nome Usuario:</label>
                        <input type="text" id="nome" required>
                    </div>
                    <div class="input-box">
                        <label for="nome">email:</label>
                        <input type="text" id="nome" required>
                    </div>
                    <div class="input-box">
                        <label for="nome">senha:</label>
                        <input type="text" id="nome" required>
                    </div>
                </div>
                <div class="botoes">
                    <div class="box-botoes">
                        <input type="submit" value="Cadastrar-se">
                    </div>
                    <div class="box-botoes">
                        <a href="login.php" class="entrar">Entrar <img src="../_fotos/arrow__forward.svg" alt=""></a>
                    </div>
                </div>
                <p class="mesagem_error" id="mensgemError"></p>
                <p class="mesagem_cadastro" id="mensagemCadastro"></p>
            </form>
        </div>
    </div>

</body>

</html>