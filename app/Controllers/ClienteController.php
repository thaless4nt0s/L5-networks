<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Repositories\ClienteRepositories\ClienteRepository;
use CodeIgniter\HTTP\ResponseInterface;

class ClienteController extends BaseController
{
    protected $clienteRepository;

    public function __construct()
    {
        $this->clienteRepository = new ClienteRepository();
    }

    public function adicionarCliente()
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
            'cpf' => $input['parametros']['cpf'] ?? null,
            'nome' => $input['parametros']['nome'] ?? null
        ];

        try {
            $resposta = $this->clienteRepository->adicionarCliente($dados);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON(
                [
                    'cabecalho' => [
                        'mensagem' => 'Erro ao criar cliente ' . $e->getMessage(),
                        'status' => 500,
                    ],
                    'retorno' => null
                ]
            );
        }
    }

    public function alterarCliente($id)
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
            'cpf' => $input['parametros']['cpf'] ?? null,
            'nome' => $input['parametros']['nome'] ?? null
        ];

        try {
            $resposta = $this->clienteRepository->alterarCliente($id, $dados);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON(
                [
                    'cabecalho' => [
                        'mensagem' => 'Erro ao alterar cliente ' . $e->getMessage(),
                        'status' => 500,
                    ],
                    'retorno' => null
                ]
            );
        }
    }

    public function removerCliente($id)
    {
        try {
            $resposta = $this->clienteRepository->removerCliente($id);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON(
                [
                    'cabecalho' => [
                        'mensagem' => 'Erro ao remover cliente ' . $e->getMessage(),
                        'status' => 500,
                    ],
                    'retorno' => null
                ]
            );
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
            $resposta = $this->clienteRepository->mostrarTodos($page, $filtros);

            // Retorna a resposta em JSON
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            // Em caso de erro, retorna uma mensagem de erro
            return $this->response->setJSON([
                'cabecalho' => [
                    'mensagem' => 'Erro ao exibir clientes: ' . $e->getMessage(),
                    'status' => 500,
                ],
                'retorno' => null
            ]);
        }
    }

    public function mostrarUm($id)
    {
        try {
            $resposta = $this->clienteRepository->mostrarUm($id);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON(
                [
                    'cabecalho' => [
                        'mensagem' => 'Erro ao exibir cliente ' . $e->getMessage(),
                        'status' => 500,
                    ],
                    'retorno' => null
                ]
            );
        }
    }
}
