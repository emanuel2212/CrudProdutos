<?php

// Inicia a sessão para armazenar e acessar variáveis de sessão.
session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Celke</title>
</head>

<body>

    <div class="container-fluid p-5 bg-black text-white text-center">
    <h1>Produtos</h1>
    </div>

<div class="container mt-4">
    <a href="index.php" class="btn btn-primary mb-2">Recarregar página</a><br>
    <a href="create.php" class="btn btn-success mb-2">Cadastrar</a><br><br>

    <?php

    // Verifica se existe uma mensagem armazenada na sessão.
    if (isset($_SESSION['msg'])) {
        // Imprime a mensagem na tela.
        echo $_SESSION['msg'];

        // Remove a mensagem da sessão para evitar que ela seja exibida novamente ao recarregar a página.
        unset($_SESSION['msg']);
    }

    // Importa a classe Connection que estabelece a conexão com o banco de dados.
    require './Connection.php';

    // Importa a classe Users que realiza a consulta aos Produtos.
    require './Users.php';

    // Instancia a classe ListUsers e armazena a referência em $listUsers.
    $listUsers = new Users();

    // Executa o método list() para obter os Produtos do banco de dados e armazena o resultado em $resultUsers.
    $resultUsers = $listUsers->list();

    if (!empty($resultUsers)) {
        echo '<table class="table table-striped">';
        echo '<thead class="table-dark">';
        echo '<tr>';
        echo '<th>Nome</th>';
        echo '<th>Preço</th>';
        echo '<th style="width: 41%;">Ações</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Percorre cada produto retornado pela consulta.
        foreach ($resultUsers as $rowUser) {
            // Extrai as chaves do array associativo para variáveis individuais.
            extract($rowUser);

            echo '<tr>';
            echo "<td>{$nome_produto}</td>";
            echo "<td>€" . number_format($preco, 2, ',', '.') . "</td>";
            echo '<td>';
            echo "<a href='view.php?id=$id_produto' class='btn btn-info btn-sm'>Visualizar</a> ";
            echo "<a href='edit.php?id=$id_produto' class='btn btn-warning btn-sm'>Editar</a> ";
            echo "<a href='delete.php?id=$id_produto' class='btn btn-danger btn-sm'>Apagar</a>";
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
      } else {
        echo '<div class="alert alert-warning">Nenhum produto encontrado.</div>';
      }
    ?>
</div>
</body>

</html>