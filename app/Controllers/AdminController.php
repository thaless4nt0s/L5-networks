<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Repositories\AdminRepositories\AdminRepository;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $adminRepository;
    public function __construct()
    {
        $this->adminRepository = new AdminRepository();
    }
}
