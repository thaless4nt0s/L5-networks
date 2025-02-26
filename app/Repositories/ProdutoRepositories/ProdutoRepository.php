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

    /**
     * Busca um produto por seu ID
     * 
     * @param int $id
     * 
     * @return array
     */
    public function buscarProdutoPorId(int $id)
    {
        return $this->db->table('produtos')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Adiciona um produto
     * @param array $dados
     * @return array{erro: string, message: string, statusCode: int|array{erro: string[], message: string, statusCode: int}|array{message: string, produto: int|string, statusCode: int}}
     */
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

    /**
     * Remove um produto
     * 
     * @param int $id
     * @return array{message: string, statusCode: int}
     */
    public function removerProduto(int $id)
    {
        $produto = $this->buscarProdutoPorId($id);
        if (!$produto) {
            return [
                'message' => 'Produto não encontrado !',
                'statusCode' => 404
            ];
        }

        if (!$this->db->table('produtos')->where('id', $id)->delete()) {
            return [
                'message' => 'Erro ao remover produto, verifique novamente !',
                'statusCode' => 400
            ];
        }

        return [
            'message' => 'Produto removido com sucesso!',
            'statusCode' => 200
        ];
    }
}