<?php

// Inicia a sessão para armazenar e acessar variáveis de sessão.
session_start();

/**
 * Ativa o buffer de saída para permitir redirecionamentos após o envio de cabeçalhos.
 */
ob_start();

/**
 * Obtém e sanitiza o ID do produto da URL.
 * 
 * @var int|null $id ID do produto ou null se não fornecido.
 */
$id_produto = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Importa a classe Connection que estabelece a conexão com o banco de dados.
require './Connection.php';

// Importa a classe Users que realiza a consulta ao produto.
require './Users.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Editar Produto</title>
</head>

<body>

    <div class="container-fluid p-5 bg-secondary text-white text-center">
        <h1>Editar</h1>
    </div>

    <div class="container mt-5">

        <!-- Links para navegação entre as páginas de listagem e cadastro de produtos -->
        <div class="d-flex justify-content-between mb-4">
            <a href="index.php"class="btn btn-primary mb-2">Página inicial </a><br><br>
        </div>

        <?php

        // Filtra os dados do formulário enviados via POST.
        $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Verifica se o formulário foi submetido.
        if (!empty($formData['EditUser'])) {

            // Cria uma nova instância da classe Users.
            $updateUser = new Users();

            // Define os dados do formulário na instância da classe Users.
            $updateUser->setFormData($formData);

            // Tenta editar o produto no banco de dados.
            $value = $updateUser->edit();

            // Verifica se o produto foi editado com sucesso.
            if ($value) {
                // Define uma mensagem de sucesso na sessão e redireciona para a página de visualização.
                $_SESSION['msg'] = "<p style='color: #086;'>produto editado com sucesso!</p>";
                // Redireciona para a página de visualização do produto.
                header("Location: view.php?id_produto=$id_produto");
            } else {
                // Exibe uma mensagem de erro se a edição falhar.
                echo "<p style='color: #f00;'>produto não editado!</p>";
            }
        }

        // Verifica se o ID do produto foi fornecido.
        if (!empty($id_produto)) {

            // Instancia a classe Users e define o ID do produto a ser visualizado.
            $viewUser = new Users();
            $viewUser->setId($id_produto);

            // Executa o método view() para obter os detalhes do produto.
            $valueUser = $viewUser->view();

            // Verifica se o produto foi encontrado e exibe os detalhes.
            if (isset($valueUser['id_produto'])) {

                // Extrai as chaves do array associativo para variáveis individuais.
                extract($valueUser);
            } else {

                // Armazena uma mensagem de erro na sessão se o produto for encontrado.
                $_SESSION['msg'] = "<p style='color: #086;'>produtoencontrado!</p>";

                // Redireciona para a página de listagem de produtos.
                header("Location: index.php");

                return;
            }
        }
        ?>

        <!-- Formulário para edição de um produto existente -->
        <form method="POST" action="" class="row g-3">

            <input type="hidden" name="id_produto" value="<?php echo $valueUser['id_produto']; ?>">

            <div class="col-md-6">
                    <label for="nome_produto" class="form-label">Nome do Produto</label>
                    <input type="text" id="nome_produto" name="nome_produto" class="form-control" value="<?php echo $valueUser['nome_produto']; ?>" required>
                </div>

            <div class="col-md-6">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="number" id="preco" name="preco" class="form-control" value="<?php echo $valueUser['preco']; ?>" step="0.01" required>
            </div>
            
            <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4" required><?php echo $valueUser['descricao']; ?></textarea>
            </div>

            <input type="submit" name="EditUser" class="btn btn-secondary btn-lg w-100" value="Editar">
        </form>
    </div>
</body>

</html>
