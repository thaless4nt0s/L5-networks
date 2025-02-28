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
            $this->produtoModel->getValidationRules(), // Regras de validação
            $this->produtoModel->getValidationMessages() // Mensagens de erro personalizadas
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            return [
                'cabecalho' => [
                    'status' => 400,
                    'mensagem' => 'Erro de validação' . $this->validation->getErrors()
                ],
                'retorno' => null
            ];
        }

        // Tenta inserir os dados no banco de dados
        try {
            $this->db->table('produtos')->insert($dados);
        } catch (\Exception $e) {
            // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro
            return [
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => 'Erro ao adicionar produto',
                ],
                'retorno' => null
            ];
        }

        // Retorna uma mensagem de sucesso
        return [
            'cabecalho' => [
                'mensagem' => 'Produto criado com sucesso!',
                'status' => 200,
            ],
            'retorno' => $this->buscarProdutoPorId($this->db->insertID())
        ];
    }

    public function alterarProduto(int $id, array $dados)
    {
        $produto = $this->buscarProdutoPorId($id);

        if (!$produto) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Produto não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }
        // Define as regras e mensagens de validação
        $this->validation->setRules(
            $this->produtoModel->validationRules, // Regras de validação
            $this->produtoModel->validationMessages // Mensagens de erro personalizadas
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro de validação' . $this->validation->getErrors(),
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }

        $this->db->table('produtos')->where('id', $id)->update($dados);

        $produtoAtualizado = $this->buscarProdutoPorId($id);

        // Retorna uma mensagem de sucesso
        return [
            'cabecalho' => [
                'mensagem' => 'Produto atualizado com sucesso!',
                'status' => 200,
            ],
            'retorno' => $produtoAtualizado
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
                'cabecalho' => [
                    'mensagem' => 'Produto não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }

        if (!$this->db->table('produtos')->where('id', $id)->delete()) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao remover produto, verifique novamente !',
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }

        return [
            'cabecalho' => [
                'mensagem' => 'Produto removido com sucesso!',
                'status' => 200,
            ],
            'retorno' => null
        ];
    }

    /**
     * Mostra todos os produtos
     * @param int $page
     * @param array $filtros
     * @return array{cabecalho: array{mensagem: string, status: int, retorno: array}}
     */
    public function mostrarTodos(int $page = 1, array $filtros = [])
    {
        unset($filtros['page']);
        // Carrega a biblioteca de paginação
        $pager = \Config\Services::pager();

        // Número de itens por página
        $perPage = 2; // Ajuste conforme necessário

        // Calcula o offset
        $offset = ($page - 1) * $perPage;

        // Inicia a consulta
        $query = $this->db->table('produtos');

        // Aplica os filtros
        foreach ($filtros as $campo => $valor) {
            if (!empty($valor)) {
                $query->like($campo, $valor); // Filtra usando "LIKE" (pode ser ajustado para outros operadores)
            }
        }

        // Executa a consulta com paginação
        $produtos = $query->select('*')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        // Total de registros filtrados (para calcular o número total de páginas)
        $total = $query->countAllResults(false); // "false" para não resetar a consulta

        // Configura a paginação
        $pager->makeLinks($page, $perPage, $total);

        // Retorna os dados filtrados e paginados
        return [
            'cabecalho' => [
                'mensagem' => 'Listagem de produtos',
                'status' => 200,
            ],
            'retorno' => [
                'produtos' => $produtos,
                'paginacao' => $pager->links() // Links de paginação
            ]
        ];
    }

    /**
     * Retorna um produto
     * @param mixed $id
     * @return array{message: string, produtos: array, statusCode: int|array{message: string, statusCode: int}}
     */
    public function mostrarUm($id)
    {
        $produto = $this->buscarProdutoPorId($id);
        if (!$produto) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Produto não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }
        return [
            'cabecalho' => [
                'mensagem' => 'Listagem de produtos',
                'status' => 200,
            ],
            'retorno' => $produto
        ];
    }
}