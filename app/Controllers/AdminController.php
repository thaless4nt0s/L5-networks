<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Repositories\AdminRepositories\AdminRepository;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $adminRepository;
    public function __construct()
    {
        $this->adminRepository = new AdminRepository();
    }

    public function adicionarAdministrador()
    {
        $dados = [
            'nome' => $this->request->getVar('nome'),
            'email' => $this->request->getVar('email'),
            'senha' => password_hash($this->request->getVar('senha'), PASSWORD_DEFAULT),
        ];
        // Criar administrador
        try {
            $admin = $this->adminRepository->criarAdministrador($dados);
            if ($admin) {
                return $this->response->setJSON([
                    'message' => 'Administrador criado com sucesso!',
                    'statusCode' => 201, // Usar 201 para criação bem-sucedida
                ]);
            } else {
                return $this->response->setJSON([
                    'message' => 'Falha ao criar administrador',
                    'statusCode' => 500 // Usar 500 para erros internos do servidor
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao criar administrador: ' . $e->getMessage(),
                'statusCode' => 500
            ]);
        }
    }
}
