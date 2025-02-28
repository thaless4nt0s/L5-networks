<?php


namespace App\Repositories\PedidosDeComprasRepositories;

interface PedidosDeComprasRepositoriesInterface
{
    public function buscarPedidoDeCompraPorId(int $id);
    public function adicionarPedidoDeCompra(array $dados);
    public function alterarPedidoDeCompra(int $id, array $dados);
    public function removerPedidoDeCompra(int $id);
    public function mostrarTodos(int $page, array $filtros);
    public function mostrarUm(int $id);
}