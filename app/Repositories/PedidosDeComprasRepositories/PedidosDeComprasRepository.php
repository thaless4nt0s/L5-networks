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
            $dados['valor_compra'] = number_format($dados['quantidade'] * $produto['valor'], 2, ',', '.');
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
}