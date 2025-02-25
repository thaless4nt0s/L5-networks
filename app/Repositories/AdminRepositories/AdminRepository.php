<?php

namespace App\Repositories\AdminRepositories;
use App\Models\AdminModel;
class AdminRepository implements AdminRepositoryInterface
{
    protected $adminModel;
    private $db;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->db = \Config\Database::connect();
    }

    public function criarAdministrador(array $dados)
    {
        return $this->db->table('admins')->insert($dados);
    }
}