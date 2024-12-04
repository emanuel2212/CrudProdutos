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

if (!empty($id_produto)) {

    // Importa a classe Connection que estabelece a conexão com o banco de dados.
    require './Connection.php';

    // Importa a classe Users que realiza a consulta ao produto.
    require './Users.php';

    // Instancia a classe Users e define o ID do produto para a operação de exclusão.
    $deleteUser = new Users();
    $deleteUser->setId($id_produto);

    // Executa a operação de exclusão do produto.
    $valueUser = $deleteUser->delete();

    // Verifica se o produto foi apagado com sucesso.
    if ($valueUser) {

        // Armazena uma mensagem de sucesso na sessão se o produto for apagado.
        $_SESSION['msg'] = "<p style='color: #086;'>Produto apagado com sucesso!</p>";

        // Redireciona para a página de listagem de produtos.
        header("Location: index.php");
    } else {

        // Armazena uma mensagem de erro na sessão se o produto não for apagado.
        $_SESSION['msg'] = "<p style='color: #f00;'>Produto não apagado!</p>";

        // Redireciona para a página de listagem de produtos.
        header("Location: index.php");
    }
} else {

    // Armazena uma mensagem de erro na sessão se o ID do produto não for fornecido.
    $_SESSION['msg'] = "<p style='color: #f00;'>produto não encontrado!</p>";

    // Redireciona para a página de listagem de produtos.
    header("Location: index.php");
}
