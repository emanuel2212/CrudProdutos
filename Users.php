<?php

/**
 * Classe para listar, visualizar, criar e editar produtos no banco de dados.
 * 
 * @author Cesar <cesar@celke.com.br>
 * @package App\Controllers
 */
class Users extends Connection
{
    /**
     * Conexão com o banco de dados.
     * @var object
     */
    public object $conn;

    /**
     * Dados do formulário para criação e edição de um novo produto.
     * @var array
     */
    public array $formData;

    /**
     * ID do produto para operações específicas (visualização e edição).
     * @var int
     */
    public int $id;

    /**
     * Define os dados do formulário para criação de um novo produto.
     * 
     * @param array $formData Dados do formulário contendo informações do produto.
     * @return void
     */
    public function setFormData(array $formData): void
    {
        // Atribui os dados do formulário à propriedade formData.
        $this->formData = $formData;
    }

    /**
     * Define o ID do produto para operações que necessitam de um identificador específico.
     * 
     * @param int $id Identificador único do produto.
     * @return void
     */
    public function setId(int $id_produto): void
    {
        // Atribui o ID do produto à propriedade id.
        $this->id = $id_produto;
    }

    /** 
     * Lista os produtos cadastrados no banco de dados.
     * 
     * @return array Retorna um array contendo os dados dos produtos.
     */
    public function list(): array
    {
        // Estabelece a conexão com o banco de dados.
        $this->conn = $this->connect();

        // Consulta SQL para selecionar os dados dos produtos, limitando o resultado a 40 registros.
        $sql = "SELECT id_produto, nome_produto, descricao, preco FROM produto ORDER BY id_produto DESC LIMIT 40";

        // Prepara a consulta SQL.
        $stmt = $this->conn->prepare($sql);

        // Executa a consulta no banco de dados.
        $stmt->execute();

        // Retorna os resultados da consulta como um array.
        return $stmt->fetchAll();
    }

    /**
     * Cria um novo produto no banco de dados.
     * 
     * @return bool Retorna true se o produto for criado com sucesso, false caso contrário.
     */
    public function create(): bool
    {
        // Estabelece a conexão com o banco de dados.
        $this->conn = $this->connect();

        // Consulta SQL para inserir um novo produto.
        $sql = "INSERT INTO produto (nome_produto, descricao, preco) VALUES (:nome_produto, :descricao, :preco)";

        // Prepara a consulta SQL para inserção de dados.
        $addUser = $this->conn->prepare($sql);

        // Associa os valores das propriedades ao SQL.
        $addUser->bindParam(':nome_produto', $this->formData['nome_produto']);
        $addUser->bindParam(':descricao', $this->formData['descricao']);
        $addUser->bindParam(':preco', $this->formData['preco']);


        // Executa a consulta SQL.
        $addUser->execute();

        // Verifica se a inserção foi bem-sucedida e retorna o resultado.
        if ($addUser->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Visualiza os detalhes de um produto específico.
     * 
     * Recupera os dados de um produto específico baseado no seu ID.
     * 
     * @return array|false Retorna um array contendo os dados do produto se encontrado, ou false se não existir.
     */
    public function view(): array|bool
    {
        // Estabelece a conexão com o banco de dados.
        $this->conn = $this->connect();

        // Consulta SQL para selecionar os dados de um produto específico.
        $sql = "SELECT id_produto, nome_produto, descricao, preco 
                FROM produto
                WHERE id_produto = :id_produto
                LIMIT 1";

        // Prepara a consulta SQL.
        $resultUser = $this->conn->prepare($sql);

        // Associa o valor do ID ao parâmetro na consulta SQL.
        $resultUser->bindParam(':id_produto', $this->id);

        // Executa a consulta SQL.
        $resultUser->execute();

        // Retorna os dados do produto ou false se não encontrado.
        return $resultUser->fetch();
    }

    /**
     * Edita as informações de um produto existente.
     * 
     * @return bool Retorna true se o produto for atualizado com sucesso, false caso contrário.
     */
    public function edit(): bool
    {
        // Estabelece a conexão com o banco de dados.
        $this->conn = $this->connect();

        // Consulta SQL para atualizar os dados do produto específico.
        $sql = "UPDATE produto SET nome_produto = :nome_produto, descricao = :descricao, preco = :preco 
                WHERE id_produto = :id_produto
                LIMIT 1";

        // Prepara a consulta SQL.
        $editUser = $this->conn->prepare($sql);

        // Associa os valores das propriedades ao SQL.
        $editUser->bindParam(':nome_produto', $this->formData['nome_produto']);
        $editUser->bindParam(':descricao', $this->formData['descricao']);
        $editUser->bindParam(':preco', $this->formData['preco']);
        $editUser->bindParam(':id_produto', $this->formData['id_produto']);


        // Executa a consulta SQL.
        $editUser->execute();

        // Verifica se a atualização foi bem-sucedida e retorna o resultado.
        if ($editUser->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Exclui um produto do banco de dados.
     * 
     * @return bool Retorna true se o produto for excluído com sucesso, false caso contrário.
     */
    public function delete(): bool
    {
        // Estabelece a conexão com o banco de dados.
        $this->conn = $this->connect();

        // Consulta SQL para excluir um produto específico baseado no seu ID.
        $sql = "DELETE FROM produto WHERE id_produto = :id_produto LIMIT 1";

        // Prepara a consulta SQL.
        $deleteUser = $this->conn->prepare($sql);

        // Associa o valor do ID ao parâmetro na consulta SQL.
        $deleteUser->bindParam(':id_produto', $this->id);

        // Executa a consulta SQL.
        return $deleteUser->execute();
    }
}
