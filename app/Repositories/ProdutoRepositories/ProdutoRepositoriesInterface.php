<?php

namespace App\Repositories\ProdutoRepositories;

interface ProdutoRepositoriesInterface
{
    public function buscarProdutoPorId(int $id);
    public function adicionarProduto(array $dados);
    public function removerProduto(int $id);
}