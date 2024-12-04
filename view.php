<?php

/**
 * Inicia a sessão para armazenar e acessar variáveis de sessão.
 */
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

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Visualizar Produto</title>
</head>

<body>
<div class="container-fluid p-5 bg-info text-white text-center">
    <h1>Visualizar Produto</h1>
    </div>
 <div class="container mt-5">
 

    <div class="d-flex justify-content-between mb-4">
            <a href="index.php"class="btn btn-primary mb-2">Página inicial </a><br><br>
    </div>

    <?php

    // Verifica se existe uma mensagem armazenada na sessão.
    if (isset($_SESSION['msg'])) {
        // Imprime a mensagem na tela.
        echo $_SESSION['msg'];

        // Remove a mensagem da sessão para evitar que ela seja exibida novamente ao recarregar a página.
        unset($_SESSION['msg']);
    }

    // Verifica se o ID foi fornecido e não está vazio.
    if (!empty($id_produto)) {

        // Importa a classe Connection que estabelece a conexão com o banco de dados.
        require './Connection.php';

        // Importa a classe Users que realiza a consulta ao produto.
        require './Users.php';

        // Instancia a classe Users e define o ID do produto a ser visualizado.
        $viewUser = new Users();
        $viewUser->setId($id_produto);

        // Executa o método view() para obter os detalhes do produto.
        $valueUser = $viewUser->view();

        // Verifica se o produto foi encontrado e exibe os detalhes.
        if (isset($valueUser['id_produto'])) {

            // Extrai as chaves do array associativo para variáveis individuais.
            extract($valueUser);
?>
           <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Campo</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ID do Produto</td>
                            <td><?php echo $id_produto; ?></td>
                        </tr>
                        <tr>
                            <td>Nome do Produto</td>
                            <td><?php echo $nome_produto; ?></td>
                        </tr>
                        <tr>
                            <td>Descrição</td>
                            <td><?php echo $descricao; ?></td>
                        </tr>
                        <tr>
                            <td>Preço</td>
                            <td>€ <?php echo number_format($preco, 2, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
<?php
        } else {

            // Armazena uma mensagem de erro na sessão se o produto não for encontrado.
            $_SESSION['msg'] = "<p style='color: #f00;'>produto não encontrado!</p>";

            // Redireciona para a página de listagem de produtos.
            header("Location: index.php");
        }
    } else {
        // Armazena uma mensagem de erro na sessão se o ID não for válido.
        $_SESSION['msg'] = "<p style='color: #f00;'>produto não encontrado!</p>";

        // Redireciona para a página de listagem de produtos.
        header("Location: index.php");
    }
    ?>
</div>
</body>

</html>