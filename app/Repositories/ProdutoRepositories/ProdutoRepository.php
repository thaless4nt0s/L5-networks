<?php

namespace App\Repositories\ProdutoRepositories;

use App\Models\ProdutoModel;
use App\Repositories\ProdutoRepositories\ProdutoRepositoriesInterface;

class ProdutoRepository implements ProdutoRepositoriesInterface
{
    protected $produtoModel;
    protected $db;
    protected $validation;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function adicionarProduto(array $dados)
    {
        // Define as regras e mensagens de validação
        $this->validation->setRules(
            $this->produtoModel->validationRules, // Regras de validação
            $this->produtoModel->validationMessages // Mensagens de erro personalizadas
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            return [
                'message' => 'Erro de validação',
                'erro' => $this->validation->getErrors(),
                'statusCode' => 400
            ];
        }

        // Tenta inserir os dados no banco de dados
        try {
            $this->db->table('produtos')->insert($dados);
        } catch (\Exception $e) {
            // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro
            return [
                'message' => 'Erro ao adicionar produto',
                'erro' => $e->getMessage(),
                'statusCode' => 500
            ];
        }

        // Retorna uma mensagem de sucesso
        return [
            'message' => 'Produto criado com sucesso!',
            'statusCode' => 200,
            'produto' => $this->db->insertID() // Retorna o ID do produto inserido
        ];
    }
}