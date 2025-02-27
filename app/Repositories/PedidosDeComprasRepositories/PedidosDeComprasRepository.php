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
                'message' => 'Cliente Não encontrado  !',
                'statusCode' => 404
            ];
        }

        if (!$produto) {
            return [
                'message' => 'Produto Não encontrado  !',
                'statusCode' => 404
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
                'message' => 'Erro de validação',
                'erro' => $this->validation->getErrors(),
                'statusCode' => 400
            ];
        }

        // Tenta inserir os dados no banco de dados
        try {
            $dados['valor_compra'] = round($dados['quantidade'] * $produto['valor'], 2);
            $this->db->table('pedidos_de_compra')->insert($dados);
            return [
                'Message' => 'Pedido Adicionado com Sucesso',
                'statusCode' => 200
            ];
        } catch (\Exception $e) {
            // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro
            return [
                'message' => 'Erro ao adicionar pedido',
                'erro' => $e->getMessage(),
                'statusCode' => 500
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
                'message' => 'Pedido não encontrado !',
                'statusCode' => 404
            ];
        }

        $cliente = $this->clienteRepository->buscarClientePorId($dados['idCliente']);
        if (!$cliente) {
            return [
                'message' => 'Cliente Não encontrado !',
                'statusCode' => 404
            ];
        }

        $produto = $this->produtoRepository->buscarProdutoPorId($dados['idProduto']);
        if (!$produto) {
            return [
                'message' => 'Produto Não encontrado !',
                'statusCode' => 404
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
                'message' => 'Erro de validação',
                'erro' => $this->validation->getErrors(),
                'statusCode' => 400
            ];
        }

        try {
            $dados['valor_compra'] = round($dados['quantidade'] * $produto['valor'], 2);
            $this->db->table('pedidos_de_compra')
                ->where('id', $id)
                ->update($dados);
            return [
                'Message' => 'Pedido atualizado com Sucesso !',
                'statusCode' => 200
            ];
        } catch (\Exception $e) {
            // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro
            return [
                'message' => 'Erro ao alterar pedido',
                'erro' => $e->getMessage(),
                'statusCode' => 500
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
                'message' => 'Pedido não encontrado',
                'statusCode' => 200
            ];
        }
        try {
            if (!$this->db->table('pedidos_de_compra')->where('id', $id)->delete()) {
                return [
                    'message' => 'Erro ao excluir Pedido',
                    'statusCode' => '400'
                ];
            }

            return [
                'message' => 'Pedido excluido com sucesso !',
                'statusCode' => 200
            ];
        } catch (\Exception $e) {
            // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro
            return [
                'message' => 'Erro ao remover pedido',
                'erro' => $e->getMessage(),
                'statusCode' => 500
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
            'message' => 'Listagem de pedidos',
            'statusCode' => 200,
            'PedidosDeCompras' => $pedidos
        ];
    }

    public function mostrarUm(int $id)
    {
        $pedido = $this->buscarPedidoDeCompraPorId($id);
        if (!$pedido) {
            return [
                'message' => 'Pedido não encontrado',
                'statusCode' => 404
            ];
        }
        return [
            'message' => 'Pedido',
            'statusCode' => 200,
            'PedidosDeCompras' => $pedido
        ];
    }
}