<?php

namespace App\Repositories\PedidosDeComprasRepositories;

use App\Database\Migrations\PedidosDeCompra;

class PedidosDeComprasRepository implements PedidosDeComprasRepositoriesInterface
{
    protected $pedidosDeComprasModel;
    protected $db;
    protected $validation;

    public function __construct()
    {
        $this->pedidosDeComprasModel = new PedidosDeCompra();
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }
}