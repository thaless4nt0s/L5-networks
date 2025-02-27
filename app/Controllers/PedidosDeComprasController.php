<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Repositories\PedidosDeComprasRepositories\PedidosDeComprasRepository;
use CodeIgniter\HTTP\ResponseInterface;

class PedidosDeComprasController extends BaseController
{
    protected $pedidosDeCompraRepository;

    public function __construct()
    {
        $this->pedidosDeCompraRepository = new PedidosDeComprasRepository();
    }

    public function adicionarPedidoDeCompra()
    {
        $input = $this->request->getJSON(true); // Obtém o JSON como array associativo

        if (!isset($input['parametros'])) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => 400,
                    'mensagem' => 'Parâmetros ausentes na requisição.'
                ],
                'retorno' => null
            ])->setStatusCode(400);
        }

        $dados = [
            'dia' => date('Y-m-d'), // Formato correto da data
            'quantidade' => $input['parametros']['quantidade'] ?? null,
            'idCliente' => $input['parametros']['idCliente'] ?? null,
            'idProduto' => $input['parametros']['idProduto'] ?? null,
            'status' => 'Em aberto'
        ];

        try {
            $resposta = $this->pedidosDeCompraRepository->adicionarPedidoDeCompra($dados);

            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => $resposta['statusCode'],
                    'mensagem' => $resposta['message']
                ],
                'retorno' => $resposta['pedido'] ?? null
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => 'Erro ao criar pedido de compra: ' . $e->getMessage()
                ],
                'retorno' => null
            ]);
        }
    }

    public function alterarPedidoDeCompra($id)
    {
        $input = $this->request->getJSON(true);

        if (!isset($input['parametros'])) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => 400,
                    'mensagem' => 'Parâmetros ausentes na requisição.'
                ],
                'retorno' => null
            ]);
        }

        $dados = [
            'dia' => $input['parametros']['dia'] ?? null,
            'quantidade' => $input['parametros']['quantidade'] ?? null,
            'idCliente' => $input['parametros']['idCliente'] ?? null,
            'idProduto' => $input['parametros']['idProduto'] ?? null,
            'status' => $input['parametros']['status'] ?? 'Em aberto'
        ];

        try {
            $resposta = $this->pedidosDeCompraRepository->alterarPedidoDeCompra($id, $dados);

            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => $resposta['statusCode'],
                    'mensagem' => $resposta['message']
                ],
                'retorno' => $resposta['pedido'] ?? null
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => 'Erro ao atualizar pedido de compra: ' . $e->getMessage()
                ],
                'retorno' => null
            ]);
        }
    }

    public function removerPedidoDeCompra(int $id)
    {
        try {
            $resposta = $this->pedidosDeCompraRepository->removerPedidoDeCompra($id);

            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => $resposta['statusCode'],
                    'mensagem' => $resposta['message']
                ],
                'retorno' => $resposta['pedido'] ?? null
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => 'Erro ao remover pedido de compra: ' . $e->getMessage()
                ],
                'retorno' => null
            ])->setStatusCode(500);
        }
    }

    public function mostrarTodos()
    {
        try {
            $resposta = $this->pedidosDeCompraRepository->mostrarTodos();

            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => $resposta['statusCode'],
                    'mensagem' => $resposta['message']
                ],
                'retorno' => $resposta['pedido'] ?? null
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => 'Erro ao exibir pedidos de compras: ' . $e->getMessage()
                ],
                'retorno' => null
            ])->setStatusCode(500);
        }
    }

    public function mostrarUm(int $id)
    {
        try {
            $resposta = $this->pedidosDeCompraRepository->mostrarUm($id);

            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => $resposta['statusCode'],
                    'mensagem' => $resposta['message']
                ],
                'retorno' => $resposta['pedido'] ?? null
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => 500,
                    'mensagem' => 'Erro ao exibir pedido de compra: ' . $e->getMessage()
                ],
                'retorno' => null
            ])->setStatusCode(500);
        }
    }
}
