<?php

namespace App\Repositories\ClienteRepositories;

use App\Models\ClienteModel;

class ClienteRepository implements ClienteRepositoryInterface
{
    protected $clienteModel;
    private $db;
    protected $validation;
    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    /**
     * Busca Cliente por Id
     * 
     * @param int $id
     */
    public function buscarClientePorId($id)
    {
        return $this->db->table('clientes')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Valida e cria um cliente
     * 
     * @param array $dados
     */
    public function adicionarCliente(array $dados)
    {
        return $this->db->table('clientes')->insert($dados);
    }

    /**
     * Altera os dados
     * 
     * @param int $id 
     * @param array $dados
     *  @return array|null
     */
    public function alterarCliente(int $id, array $dados)
    {
        // Busca o cliente pelo ID
        $cliente = $this->buscarClientePorId($id);

        // Verifica se o cliente existe
        if (!$cliente) {
            return [
                'erro' => 'Erro ao atualizar cliente',
                'message' => 'Cliente não encontrado',
                'statusCode' => 404
            ];
        }

        // Define as regras e mensagens de validação
        $this->validation->setRules(
            $this->clienteModel->validationRules, // Regras de validação
            $this->clienteModel->validationMessages // Mensagens de erro personalizadas
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            return [
                'message' => 'Erro de validação',
                'erro' => $this->validation->getErrors(),
                'statusCode' => 400
            ];
        }

        // Atualiza os dados do cliente
        $this->db->table('clientes')
            ->where('id', $id)
            ->update($dados);

        // Retorna o cliente atualizado
        return [
            'message' => 'Cliente atualizado com sucesso!',
            'statusCode' => 200,
            'cliente' => $this->buscarClientePorId($id)
        ];
    }

    /**
     * 
     * @param int $id
     * @return array{erro: string, message: string, statusCode: int|array{message: string, statusCode: int}}
     */
    public function removerCliente(int $id)
    {
        // Busca o cliente pelo ID
        $cliente = $this->buscarClientePorId($id);

        // Verifica se o cliente existe
        if (!$cliente) {
            return [
                'erro' => 'Erro ao atualizar cliente',
                'message' => 'Cliente não encontrado',
                'statusCode' => 404
            ];
        }

        if (!$this->db->table('clientes')->where('id', $id)->delete()) {
            return [
                'message' => 'Erro ao remover cliente, verifique novamente !',
                'statusCode' => 400
            ];
        }

        return [
            'message' => 'Cliente removido com sucesso!',
            'statusCode' => 200
        ];
    }

    public function mostrarTodos()
    {
        $clientes = $this->db->table('clientes')->get()->getResultArray();

        return [
            'message' => 'Listagem de clientes',
            'statusCode' => 200,
            'clientes' => $clientes
        ];
    }
}