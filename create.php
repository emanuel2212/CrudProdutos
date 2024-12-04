<?php

// Inicia a sessão para armazenar e acessar variáveis de sessão.
session_start();

/**
 * Ativa o buffer de saída para permitir redirecionamentos após o envio de cabeçalhos.
 */
ob_start();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Cadastrar Produto</title>
</head>

<body>

<div class="container-fluid p-5 bg-success text-white text-center">
        <h1>Cadastrar</h1>
    </div>

    <div class="container mt-5">

    

        <!-- Links para navegação entre as páginas de listagem e cadastro de produtos -->
        <div class="d-flex justify-content-between mb-4">
            <a href="index.php"class="btn btn-primary mb-2">Página inicial </a><br><br>
        </div>

        <?php

        // Importa a classe Connection que estabelece a conexão com o banco de dados.
        require './Connection.php';

        // Importa a classe Users que realiza a consulta aos produtos.
        require './Users.php';

        // Filtra os dados do formulário enviados via POST.
        $formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Verifica se o formulário foi submetido.
        if (!empty($formData['AddUser'])) {

            // Cria uma nova instância da classe Users.
            $createUser = new Users();
            
            // Define os dados do formulário na instância da classe Users.
            $createUser->setFormData($formData);
            
            // Tenta criar um novo Produto no banco de dados.
            $value = $createUser->create();

            // Verifica se o Produto foi criado com sucesso.
            if ($value) {
                // Define uma mensagem de sucesso na sessão e redireciona para a página de listagem.
                $_SESSION['msg'] = "<p style='color: #086;'>Produto cadastrado com sucesso!</p>";
                header("Location: index.php");
            } else {
                // Exibe uma mensagem de erro se o cadastro falhar.
                echo "<p style='color: #f00;'>Produto não cadastrado!</p>";
            }
        }
        ?>

        <!-- Formulário para cadastro de um novo Produto -->
        <form method="POST" action="" class="row g-3">

            <div class="col-md-6">
                    <label for="nome_produto" class="form-label">Nome do Produto</label>
                        <input type="text"  name="nome_produto" class="form-control" placeholder="Nome do Produto" required>
                    </div>

                    <div class="col-md-6">
                        <label for="preco" class="form-label">Preço</label>
                        <input type="number"  name="preco" class="form-control" placeholder="Valor" step="0.01" required>
                    </div>

                    <div class="col-12">
                        <label for="descricao" class="form-label">Descrição do Produto</label>
                        <textarea  name="descricao" class="form-control" rows="4" placeholder="Descreva o produto" required></textarea>
                    </div>

                    <div class="col-12 text-center">
                        <input type="submit" name="AddUser" class="btn btn-success btn-lg w-100" value="Cadastrar Produto">
                    </div>
            </div>
        </form>
    </div>
</body>

</html>
