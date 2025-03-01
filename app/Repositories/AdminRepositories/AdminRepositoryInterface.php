<?php

namespace App\Repositories\AdminRepositories;

use CodeIgniter\HTTP\RequestInterface;

interface AdminRepositoryInterface
{
    public function buscarAdministradorPorId(int $id);
    public function criarAdministrador(array $dados);
    public function alterarDadosDoAministrador(int $id, array $dados, RequestInterface $request);
    public function removerAdministrador(int $id, RequestInterface $request);
}