<?php
require_once("../_conexaoPHP/conexao.php");
require_once("../paginas/_incluir/funcoes.php");
?>
<?php
if (isset($_GET['codigo'])) {
    $produto_id = $_GET["codigo"];
} else {
    header("Location:produtos.php");
    exit; // Para o script após redirecionamento
}

// Consulta do produto com especificação de colunas
$consulta = "SELECT Produtos.id AS produtoID, Produtos.nome_produto AS nomeproduto, 
                        Produtos.descricao_curta, Produtos.descricao_longa, 
                        Produtos.img_produto, Produtos.preco, Produtos.estoque, 
                        Fornecedores.nome_fornecedor 
                 FROM Produtos 
                 JOIN Fornecedores ON Produtos.fornecedor_id = Fornecedores.id 
                 WHERE Produtos.id = {$produto_id}"; // Especifica Produtos.id

$detalhe = mysqli_query($conecta, $consulta);

// Testa erro
if (!$detalhe) {
    die("Falha na consulta detalhada do produto");
} else {
    $dados_detalhe = mysqli_fetch_assoc($detalhe);
    $produtoID      = $dados_detalhe["produtoID"];
    $nomeproduto    = $dados_detalhe["nomeproduto"];
    $descricao_curta = $dados_detalhe["descricao_curta"];
    $descricao_longa = $dados_detalhe["descricao_longa"];
    $imgproduto     = $dados_detalhe["img_produto"];
    $preco          = $dados_detalhe["preco"];
    $estoque        = $dados_detalhe["estoque"];
    $nome_fornecedor = $dados_detalhe["nome_fornecedor"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../_css/detalhes.css">
    <link rel="stylesheet" href="../paginas/reset_repeticao.css">
    <title>Detalhes</title>
</head>

<body>
    <header class="cabecario">
        <div class="logo">
            <h2>Saúde+</h2>
        </div>
        <nav>
            <a href="../paginas/produtos.php">Produtos</a>
            <a href="../paginas/sobre.html">Sobre</a>
            <a href="../paginas/contato.html">Contato</a>
        </nav>
    </header>
    <main class="principal">
        <div class="detalhes">
            <img src="<?php echo $imgproduto; ?>" alt="Imagem do Produto">
            <article class="informacao">
                <h2><?php echo $nomeproduto; ?></h2>
                <p><b>Preço:</b> R$ <?php echo number_format($preco, 2, ',', '.'); ?></p>
                <p><b>Estoque:</b> <?php echo $estoque; ?></p>
                <p><b>Fornecedor:</b> <?php echo $nome_fornecedor; ?></p>
                <p><b>Descrição:</b> <?php echo $descricao_longa; ?></p>
            </article>
            <div class="botoes">
            <a href="">comprar</a>
            <a href="../paginas/produtos.php">Voltar para Produtos</a>
            </div>
        </div>
    </main>
</body>

</html>