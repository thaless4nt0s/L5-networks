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
            $resposta = $this->clienteRepository->mostrarTodos();
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON(
                [
                    'cabecalho' => [
                        'mensagem' => 'Erro ao exibir clientes ' . $e->getMessage(),
                        'status' => 500,
                    ],
                    'retorno' => null
                ]
            );
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
