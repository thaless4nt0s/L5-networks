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
            'nome' => $input['parametros']['nome'] ?? null,
            'valor' => isset($input['parametros']['valor'])
                ? number_format($input['parametros']['valor'], 2, '.', '')
                : null
        ];
        try {
            $resposta = $this->produtoRepository->adicionarProduto($dados);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'statusCode' => 500,
                    'mensagem' => 'Erro ao criar produto: ' . $e->getMessage(),
                ],
                'retorno' => null
            ]);
        }
    }

    public function alterarProduto($id)
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
            'nome' => $input['parametros']['nome'] ?? null,
            'valor' => isset($input['parametros']['valor'])
                ? number_format($input['parametros']['valor'], 2, '.', '')
                : null
        ];

        try {
            $resposta = $this->produtoRepository->alterarProduto($id, $dados);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao alterar produto: ' . $e->getMessage(),
                'statusCode' => 500
            ]);
        }
    }

    public function removerProduto($id)
    {
        try {
            $resposta = $this->produtoRepository->removerProduto($id);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao remover produto: ' . $e->getMessage(),
                    'status' => 500,
                ],
                'retorno' => null
            ];
        }
    }

    public function mostrarTodos()
    {
        try {
            // Captura o número da página (se não for especificado, assume a página 1)
            $page = $this->request->getVar('page') ?? 1;

            // Captura os filtros da requisição (query string ou corpo)
            $filtros = $this->request->getGet(); // Ou $this->request->getPost() para POST

            // Chama o repositório, passando a página e os filtros
            $resposta = $this->produtoRepository->mostrarTodos($page, $filtros);

            // Retorna a resposta em JSON
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            // Em caso de erro, retorna uma mensagem de erro
            return $this->response->setJSON([
                'message' => 'Erro ao listar produtos: ' . $e->getMessage(),
            ])->setStatusCode(500);
        }
    }
    public function mostrarUm($id)
    {
        try {
            $resposta = $this->produtoRepository->mostrarUm($id);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao remover produto: ' . $e->getMessage(),
            ])->setStatusCode(500);
        }
    }

}