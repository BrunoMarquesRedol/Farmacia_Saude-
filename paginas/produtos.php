<?php
require_once("../_conexaoPHP/conexao.php");
require_once("../paginas/_incluir/funcoes.php");
?>
<?php
//iniciar variavel sessão
session_start();

if (!isset($_SESSION['user_portal'])) {
    header('location:login.php');
}

//consulta de dados dos usuarios
$id_usuario = $_SESSION['user_portal'];

$usuarios = "SELECT * FROM Usuarios
    WHERE id = {$id_usuario}";

$usuario = mysqli_query($conecta, $usuarios);

$saudacao = mysqli_fetch_assoc($usuario);

//consulta de dados dos produtos
$produtos = "SELECT Produtos.*, Categorias.nome_categoria 
             FROM Produtos 
             LEFT JOIN Categorias ON Produtos.categoria_id = Categorias.id";
if (isset($_GET["pesquisa_produto"])) {
    $nome_produto = $_GET["pesquisa_produto"];
    $produtos .= " WHERE nome_produto LIKE '%{$nome_produto}%' ";
}
$Resultado = mysqli_query($conecta, $produtos);
if (!$Resultado) {
    die("Falha na consulta ao banco (produtos)");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Saude+</title>
    <link rel="stylesheet" href="../_css/reset_repeticao.css">
    <link rel="stylesheet" href="../_css/produtos.css">

</head>

<body>
    <header>
        <div class="logo">Saude+</div>

        <div class="aba_pesquisa">
            <form action="produtos.php" method="get">
                <input type="image" class="seach" src="../_fotos/lupa_pesquisa.jpg" width="20px">
                <input type="text" class="campo_seach" name="pesquisa_produto">
            </form>
        </div>
        <nav>
            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <ul class="nav-list">
                <li><a href="../paginas/home_page.html"><img src="../_fotos/home.jpg" width="20px"><b>Home</b></a></li>
                <li><a href="../paginas/sobre.html"><img src="../_fotos/sobre nos.jpg" width="20px"><b>Sobre Nós</b></a></li>
                <li><a href="../paginas/contato.html"><img src="../_fotos/contate-nos.jpg" width="20px"><b>Contatos</b></a></li>
                <li><a href="../paginas/login.php"><img src="../_fotos/Usuario.jpg" width="20px"><b>Login</b></a></li>
            </ul>



        </nav>

    </header>
    <div class="container">
        <div class="sidebar">
            <div class="filter-container">
                <h3>Filtrar Produtos</h3>
                <label for="category">Categoria:</label>
                <select id="category" onchange="filterProducts()">
                    <option value="">Todas</option>
                    <option value="analgesicos">Analgésicos</option>
                    <option value="antibioticos">Antibióticos</option>
                </select>
                <label for="sort">Ordenar por:</label>
                <select id="sort" onchange="sortProducts()">
                    <option value="relevance">Relevância</option>
                    <option value="price">Preço</option>
                    <option value="name">Nome</option>
                    <option value="rating">Avaliação</option>
                    <option value="date">Data de Lançamento</option>
                </select>
                <h4>Faixa de Preço</h4>
                <div class="range-labels">
                    <span id="minPriceLabel">0</span>
                    <span id="maxPriceLabel">50</span>
                </div>
                <input type="range" id="minPrice" min="0" max="50" value="0" onchange="updateLabels()" />
                <input type="range" id="maxPrice" min="0" max="50" value="50" onchange="updateLabels()" />
                <button onclick="filterProducts()">Filtrar</button>
            </div>
        </div>
        <main>
            <div class="h1">
                <h1>Produtos</h1>
            </div>
            <!-- ALTERAÇÃO  -->
            <div class="products" id="productContainer">

                <?php while ($consulta = mysqli_fetch_assoc($Resultado)) { ?>
                    <div class="product-card" data-price="<?php echo $consulta["preco"] ?>" data-category="<?php echo $consulta["nome_categoria"] ?>">
                        <img src="<?php echo $consulta["imgproduto"] ?>" width="30px" alt="Dipirona em Gotas" class="product-image">
                        <h3><?php echo $consulta['nome_produto'] ?></h3>
                        <p><?php echo $consulta['descricao_curta'] ?></p>
                        <h3>Preço:<?php echo real_format($consulta["preco"]) ?></h3>
                        <a class="botao" href="detalhes.php?codigo=<?php echo $consulta["id"] ?>"><button>Comprar</button></a>
                    </div>
                <?php } ?>


            </div>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Saude+. Todos os direitos reservados.</p>
    </footer>
    <script>
        const products = Array.from(document.querySelectorAll('.product-card'));

        function sortProducts() {
            const sortValue = document.getElementById('sort').value;
            let sortedProducts;

            if (sortValue === 'price') {
                sortedProducts = products.sort((a, b) => {
                    return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
                });
            } else if (sortValue === 'name') {
                sortedProducts = products.sort((a, b) => {
                    return a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent);
                });
            } else if (sortValue === 'rating') {
                sortedProducts = products.sort((a, b) => {
                    return parseFloat(b.getAttribute('data-rating')) - parseFloat(a.getAttribute('data-rating'));
                });
            } else if (sortValue === 'date') {
                // Implementar ordenação pela data se necessário
                sortedProducts = products; // Placeholder
            } else {
                sortedProducts = products; // Relevância não altera a ordem
            }

            displayProducts(sortedProducts);
        }

        function filterProducts() {
            const minPrice = parseFloat(document.getElementById('minPrice').value);
            const maxPrice = parseFloat(document.getElementById('maxPrice').value);
            const selectedCategory = document.getElementById('category').value;

            const filteredProducts = products.filter(product => {
                const price = parseFloat(product.getAttribute('data-price'));
                const category = product.getAttribute('data-category');

                return price >= minPrice && price <= maxPrice &&
                    (selectedCategory === "" || category === selectedCategory);
            });

            displayProducts(filteredProducts);
        }

        function updateLabels() {
            const minPrice = document.getElementById('minPrice').value;
            const maxPrice = document.getElementById('maxPrice').value;

            document.getElementById('minPriceLabel').textContent = minPrice;
            document.getElementById('maxPriceLabel').textContent = maxPrice;
        }

        function displayProducts(productList) {
            const productContainer = document.getElementById('productContainer');
            productContainer.innerHTML = ''; // Limpa o container

            productList.forEach(product => {
                productContainer.appendChild(product); // Adiciona cada produto filtrado
            });
        }
    </script>

    <script src="./javascript/mobile-navbar.js">
    </script>
</body>

</html>