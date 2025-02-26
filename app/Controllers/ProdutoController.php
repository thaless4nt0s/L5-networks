<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Repositories\ProdutoRepositories\ProdutoRepository;
use CodeIgniter\HTTP\ResponseInterface;

class ProdutoController extends BaseController
{
    protected $produtoRepository;

    public function __construct()
    {
        $this->produtoRepository = new ProdutoRepository();
    }

    public function adicionarProduto()
    {
        $dados = [
            'nome' => $this->request->getVar('nome'),
            'valor' => $this->request->getVar('valor'),
        ];

        try {
            $resposta = $this->produtoRepository->adicionarProduto($dados);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao criar produto: ' . $e->getMessage(),
                'statusCode' => 500
            ])->setStatusCode(500);
        }
    }

    public function removerProduto($id)
    {
        try {
            $resposta = $this->produtoRepository->removerProduto($id);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao remover produto: ' . $e->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function mostrarTodos()
    {
        try {
            $resposta = $this->produtoRepository->mostrarTodos();
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao remover produto: ' . $e->getMessage(),
            ])->setStatusCode(500);
        }
    }
}