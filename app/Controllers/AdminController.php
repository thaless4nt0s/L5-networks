<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use app\Controllers\Login;
use App\Repositories\AdminRepositories\AdminRepository;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    use ResponseTrait;
    protected $adminRepository;
    public function __construct()
    {
        $this->adminRepository = new AdminRepository();
    }

    public function adicionarAdministrador()
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
            'nome' => $input['parametros']['nome'],
            'email' => $input['parametros']['email'],
            'senha' => password_hash($input['parametros']['senha'], PASSWORD_DEFAULT),
        ];

        // Criar administrador
        try {
            $resposta = $this->adminRepository->criarAdministrador($dados);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao criar administrador: ' . $e->getMessage(),
                'statusCode' => 500
            ]);
        }
    }

    public function alterarDadosDoAdministrador($id)
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
            'nome' => $input['parametros']['nome'],
            'email' => $input['parametros']['email'],
            'senha' => password_hash($input['parametros']['senha'], PASSWORD_DEFAULT),
        ];

        try {
            $resposta = $this->adminRepository->alterarDadosDoAministrador(
                $id,
                $dados,
                $this->request
            );
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao alterar dados de um administrador: ' . $e->getMessage(),
                'statusCode' => 500
            ]);
        }
    }

    public function removerAdministrador($id)
    {
        try {
            $resposta = $this->adminRepository->removerAdministrador($id, $this->request);
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'message' => 'Erro ao remover um administrador: ' . $e->getMessage(),
                'statusCode' => 500
            ]);
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
            $resposta = $this->adminRepository->mostrarTodos($page, $filtros);

            // Retorna a resposta em JSON
            return $this->response->setJSON($resposta);
        } catch (\Exception $e) {
            // Em caso de erro, retorna uma mensagem de erro
            return $this->response->setJSON([
                'cabecalho' => [
                    'mensagem' => 'Erro ao exibir administradores: ' . $e->getMessage(),
                    'status' => 500,
                ],
                'retorno' => null
            ]);
        }
    }
}
