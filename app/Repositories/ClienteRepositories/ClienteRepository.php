<?php

namespace App\Repositories\ClienteRepositories;

use App\Models\ClienteModel;
use Exception;
use function PHPUnit\Framework\throwException;

class ClienteRepository implements ClienteRepositoryInterface
{
    protected $clienteModel;
    private $db;
    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Valida e cria um cliente
     */
    public function adicionarCliente(array $dados)
    {
        return $this->db->table('clientes')->insert($dados);
    }
}