<?php

namespace App\Repositories\ClienteRepositories;

interface ClienteRepositoryInterface
{
    public function buscarClientePorId(int $id);
    public function adicionarCliente(array $dados);
    public function alterarCliente(int $id, array $dados);
}

?>