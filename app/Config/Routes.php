<?php

use App\Controllers\AdminController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('admin', function ($routes) {
    $routes->post('', 'AdminController::adicionarAdministrador');
    $routes->post("login", "Login::index");
    $routes->put('(:num)', 'AdminController::alterarDadosDoAdministrador/$1', ['filter' => 'jwtAuth']);
    $routes->delete('(:num)', 'AdminController::removerAdministrador/$1', ['filter' => 'jwtAuth']);
    $routes->get('', 'AdminController::mostrarTodos');
    $routes->get('(:num)', 'AdminController::mostrarUm/$1');
});

$routes->group('clientes', ['filter' => 'jwtAuth'], function ($routes) {
    $routes->post('', 'ClienteController::adicionarCliente');
    $routes->put('(:num)', 'ClienteController::alterarCliente/$1');
    $routes->delete('(:num)', 'ClienteController::removerCliente/$1');
    $routes->get('', 'ClienteController::mostrarTodos');
    $routes->get('(:num)', 'ClienteController::mostrarUm/$1');
});

$routes->group('produtos', ['filter' => 'jwtAuth'], function ($routes) {
    $routes->post('', 'ProdutoController::adicionarProduto');
    $routes->put('(:num)', 'ProdutoController::alterarProduto/$1');
    $routes->delete('(:num)', 'ProdutoController::removerProduto/$1');
    $routes->get('', 'ProdutoController::mostrarTodos');
    $routes->get('(:num)', 'ProdutoController::mostrarUm/$1');
});

$routes->group('pedidosDeCompra', ['filter' => 'jwtAuth'], function ($routes) {
    $routes->post('', 'PedidosDeComprasController::adicionarPedidoDeCompra');
    $routes->put('(:num)', 'PedidosDeComprasController::alterarPedidoDeCompra/$1');
    $routes->delete('(:num)', 'PedidosDeComprasController::removerPedidoDeCompra/$1');
    $routes->get('', 'PedidosDeComprasController::mostrarTodos');
    $routes->get('(:num)', 'PedidosDeComprasController::mostrarUm/$1');
});