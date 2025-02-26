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
});
