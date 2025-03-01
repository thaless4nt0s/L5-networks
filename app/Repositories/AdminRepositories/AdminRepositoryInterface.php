<?php

namespace App\Repositories\AdminRepositories;

use CodeIgniter\HTTP\RequestInterface;

interface AdminRepositoryInterface
{
    public function criarAdministrador(array $dados);
    public function alterarDadosDoAministrador(int $id, array $dados, RequestInterface $request);
}