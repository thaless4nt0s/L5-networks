<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('admin/', function ($routes) {
    $routes->post('criar', 'AdminController::adicionarAdministrador');
    $routes->post("login", "Login::index");
});

$routes->group('clientes', function ($routes) {
    $routes->post('', 'ClienteController::adicionarCliente');
    $routes->put('(:num)', 'ClienteController::alterarCliente/$1');
    $routes->delete('(:num)', 'ClienteController::removerCliente/$1');
    $routes->get('', 'ClienteController::mostrarTodos');
    $routes->get('(:num)', 'ClienteController::mostrarUm/$1');
});

$routes->group('produtos', function ($routes) {
    $routes->post('', 'ProdutoController::adicionarProduto');
    $routes->put('(:num)', 'ProdutoController::alterarProduto/$1');
    $routes->delete('(:num)', 'ProdutoController::removerProduto/$1');
    $routes->get('', 'ProdutoController::mostrarTodos');
    $routes->get('(:num)', 'ProdutoController::mostrarUm/$1');
});

$routes->group('pedidosDeCompra', function ($routes) {
    $routes->post('', 'PedidosDeComprasController::adicionarPedidoDeCompra');
    $routes->put('(:num)', 'PedidosDeComprasController::alterarPedidoDeCompra/$1');
    $routes->delete('(:num)', 'PedidosDeComprasController::removerPedidoDeCompra/$1');
    $routes->get('', 'PedidosDeComprasController::mostrarTodos');
});