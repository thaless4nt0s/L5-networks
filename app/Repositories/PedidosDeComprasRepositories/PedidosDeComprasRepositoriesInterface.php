<?php


namespace App\Repositories\PedidosDeComprasRepositories;

interface PedidosDeComprasRepositoriesInterface
{
    public function buscarPedidoDeCompraPorId(int $id);
    public function adicionarPedidoDeCompra(array $dados);
    public function alterarPedidoDeCompra(int $id, array $dados);
}