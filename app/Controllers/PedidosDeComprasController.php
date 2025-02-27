<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Repositories\PedidosDeComprasRepositories\PedidosDeComprasRepository;
use CodeIgniter\HTTP\ResponseInterface;

class PedidosDeComprasController extends BaseController
{
    protected $pedidosDeCompraRepository;
    public function __construct()
    {
        $this->pedidosDeCompraRepository = new PedidosDeComprasRepository();
    }
}
