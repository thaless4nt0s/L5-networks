<?php

namespace App\Repositories\AdminRepositories;
use App\Models\AdminModel;
class AdminRepository implements AdminRepositoryInterface
{
    protected $adminModel;
    private $db;
    protected $validation;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
    }

    public function buscarAdministradorPorId(int $id)
    {
        return $this->db->table('admins')
            ->select('nome, email')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    public function criarAdministrador(array $dados)
    {
        $this->validation->setRules(
            $this->adminModel->getValidationRules(),
            $this->adminModel->getValidationMessages()
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            // Converte o array de erros em uma string
            $erros = implode(' ', $this->validation->getErrors());

            return [
                'cabecalho' => [
                    'mensagem' => 'Erro de validação: ' . $erros, // Concatena a string de erros
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }

        try {
            $this->db->table('admins')->insert($dados);
            return [
                'cabecalho' => [
                    'mensagem' => 'Administrador adicionado com sucesso',
                    'status' => 200
                ],
                'retorno' => $this->buscarAdministradorPorId($this->db->insertID())
            ];
        } catch (\Exception $e) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao adicionar administrador: ' . $e->getMessage(),
                    'status' => 500,
                ],
                'retorno' => null
            ];
        }
    }
}