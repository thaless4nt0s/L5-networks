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
        $dados = [
            'dia' => date('Y-m-d'), // Correção da formatação da data
            'quantidade' => $this->request->getVar('quantidade'),
            'idCliente' => $this->request->getVar('idCliente'),
            'idProduto' => $this->request->getVar('idProduto'),
            'status' => 'Em aberto' // Sempre passará 'Em aberto' quando se adiciona um pedido
        ];

        try {
            $resposta = $this->pedidosDeCompraRepository->adicionarPedidoDeCompra($dados);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao criar pedido de compra: ' . $e->getMessage(),
                'statusCode' => 500
            ])->setStatusCode(500);
        }
    }

}
