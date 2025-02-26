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
});