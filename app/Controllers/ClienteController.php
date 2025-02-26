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
        $dados = [
            'cpf' => $this->request->getVar('cpf'),
            'nome' => $this->request->getVar('nome')
        ];

        try {
            $cliente = $this->clienteRepository->adicionarCliente($dados);

            if ($cliente) {
                return $this->response->setJSON([
                    'message' => 'Clente criado com sucesso!',
                    'statusCode' => 201, // Usar 201 para criação bem-sucedida
                ]);
            }

            return $this->response->setJSON([
                'message' => 'Falha ao criar cliente',
                'statusCode' => 500 // Usar 500 para erros internos do servidor
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao criar cliente: ' . $e->getMessage(),
                'statusCode' => 500
            ]);
        }
    }

    public function alterarCliente($id)
    {
        $dados = [
            'cpf' => $this->request->getVar('cpf'),
            'nome' => $this->request->getVar('nome')
        ];
        try {
            $resposta = $this->clienteRepository->alterarCliente($id, $dados);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao criar cliente: ' . $e->getMessage(),
                'statusCode' => 500
            ]);
        }
    }
}
