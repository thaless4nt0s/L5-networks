<?php

namespace App\Repositories\PedidosDeComprasRepositories;

use App\Database\Migrations\PedidosDeCompra;
use App\Models\PedidosDeCompraCompraModel;
use App\Repositories\ClienteRepositories\ClienteRepository;
use App\Repositories\ProdutoRepositories\ProdutoRepository;

class PedidosDeComprasRepository implements PedidosDeComprasRepositoriesInterface
{
    protected $pedidosDeComprasModel;
    protected $db;
    protected $validation;

    protected $clienteRepository;
    protected $produtoRepository;

    public function __construct()
    {
        $this->pedidosDeComprasModel = new PedidosDeCompraCompraModel();
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
        $this->produtoRepository = new ProdutoRepository();
        $this->clienteRepository = new ClienteRepository();
    }

    /**
     * Retorna um pedido de compra buscando pelo seu ID
     * @param int $id
     * @return array|null
     */
    public function buscarPedidoDeCompraPorId(int $id)
    {
        return $pedido = $this->db->table('pedidos_de_compra')
            ->select('pedidos_de_compra.*, clientes.nome AS nomeCliente, produtos.nome AS nomeProduto, produtos.valor as valorProdutoIndividual')
            ->join('clientes', 'clientes.id = pedidos_de_compra.idCliente')
            ->join('produtos', 'produtos.id = pedidos_de_compra.idProduto')
            ->where('pedidos_de_compra.id', $id)
            ->get()
            ->getRowArray();
        ;
    }

    /**
     * Adicionar pedido de compra
     * @param array $dados
     * @return array{erro: string, message: string, statusCode: int|array{erro: string[], message: string, statusCode: int}|array{message: string, statusCode: int}|array{Message: string, statusCode: int}}
     */
    public function adicionarPedidoDeCompra(array $dados)
    {
        $cliente = $this->clienteRepository->buscarClientePorId($dados['idCliente']);
        $produto = $this->produtoRepository->buscarProdutoPorId($dados['idProduto']);

        if (!$cliente) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Cliente não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }

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
            $this->pedidosDeComprasModel->getValidationRules(), // Regras de validação
            $this->pedidosDeComprasModel->getValidationMessages() // Mensagens de erro personalizadas
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro de validação ' . $this->validation->getErrors(),
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }

        // Tenta inserir os dados no banco de dados
        try {
            $dados['valor_compra'] = round($dados['quantidade'] * $produto['valor'], 2);
            $this->db->table('pedidos_de_compra')->insert($dados);
            $idInserido = $this->db->insertID();
            return [
                'cabecalho' => [
                    'mensagem' => 'Pedido criado com sucesso',
                    'status' => 200,
                ],
                'retorno' => $this->buscarPedidoDeCompraPorId($idInserido)
            ];
        } catch (\Exception $e) {
            // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao adicionar pedido ' . $e->getMessage(),
                    'status' => 500,
                ],
                'retorno' => $this->buscarPedidoDeCompraPorId($idInserido)
            ];
        }
    }

    /**
     * Alterar o pedido de uma compra
     * @param int $id
     * @param array $dados
     * @return array{erro: string, message: string, statusCode: int|array{erro: string[], message: string, statusCode: int}|array{message: string, statusCode: int}|array{Message: string, statusCode: int}}
     */
    public function alterarPedidoDeCompra(int $id, array $dados)
    {
        $pedido = $this->buscarPedidoDeCompraPorId($id);
        if (!$pedido) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Pedido não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }

        $cliente = $this->clienteRepository->buscarClientePorId($dados['idCliente']);
        if (!$cliente) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Cliente não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }

        $produto = $this->produtoRepository->buscarProdutoPorId($dados['idProduto']);
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
            $this->pedidosDeComprasModel->getValidationRules(), // Regras de validação
            $this->pedidosDeComprasModel->getValidationMessages() // Mensagens de erro personalizadas
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro de validação ' . $this->validation->getErrors(),
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }

        try {
            $dados['valor_compra'] = round($dados['quantidade'] * $produto['valor'], 2);
            $this->db->table('pedidos_de_compra')
                ->where('id', $id)
                ->update($dados);
            return [
                'cabecalho' => [
                    'mensagem' => 'Pedido atualizado com sucesso',
                    'status' => 200,
                ],
                'retorno' => $this->buscarPedidoDeCompraPorId($id)
            ];

        } catch (\Exception $e) {
            // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao alterar pedido ' . $e->getMessage(),
                    'status' => 500,
                ],
                'retorno' => null
            ];

        }
    }

    /**
     * Remove um pedido
     * @param int $id
     * @return array{erro: string, message: string, statusCode: int|array{message: string, statusCode: int|string}|array{message: string, statusCode: int}}
     */
    public function removerPedidoDeCompra(int $id)
    {
        $pedido = $this->buscarPedidoDeCompraPorId($id);
        if (!$pedido) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Pedido não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }
        try {
            if (!$this->db->table('pedidos_de_compra')->where('id', $id)->delete()) {
                return [
                    'cabecalho' => [
                        'mensagem' => 'Erro ao excluir pedido',
                        'status' => 400,
                    ],
                    'retorno' => null
                ];
            }

            return [
                'cabecalho' => [
                    'mensagem' => 'Pedido excluido com sucesso ',
                    'status' => 200,
                ],
                'retorno' => null
            ];
        } catch (\Exception $e) {
            // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao remover pedido' . $e->getMessage(),
                    'status' => 500,
                ],
                'retorno' => null
            ];

        }
    }

    /**
     * Mostrar todas os pedidos de compras
     * @return array{PedidosDeCompras: array, message: string, statusCode: int}
     */
    public function mostrarTodos()
    {
        $pedidos = $this->db->table('pedidos_de_compra')
            ->select('pedidos_de_compra.*, clientes.nome AS nomeCliente, produtos.nome AS nomeProduto, produtos.valor as valorProdutoIndividual')
            ->join('clientes', 'clientes.id = pedidos_de_compra.idCliente')
            ->join('produtos', 'produtos.id = pedidos_de_compra.idProduto')
            ->get()->getResultArray();
        return [
            'cabecalho' => [
                'mensagem' => 'Listagem de todos os pedidos',
                'status' => 200,
            ],
            'retorno' => $pedidos
        ];
    }

    public function mostrarUm(int $id)
    {
        $pedido = $this->buscarPedidoDeCompraPorId($id);
        if (!$pedido) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Pedido não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }
        return [
            'cabecalho' => [
                'mensagem' => 'Listagem De um Pedido',
                'status' => 200,
            ],
            'retorno' => $pedido
        ];
    }
}