<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nome', 'email', 'senha'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nome' => 'required|min_length[3]|max_length[50]',
        'email' => 'required|valid_email|max_length[70]',
        'password' => 'required|min_length[8]'
    ];
    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatório',
            'min_length' => 'O campo precisa ter pelo menos 3 caracteres',
            'max_length' => 'O campo não pode ter pelo mais que 50 caracteres',
        ],
        'email' => [
            'required' => 'O campo e-mail é obrigatório',
            'valid_email' => 'O e-mail precisa ser válido',
            'max_length' => 'O campo não pode ter pelo mais que 70 caracteres',
        ],
        'senha' => [
            'required' => 'O campo senha é obrigatório',
            'min_length' => 'O campo precisa ter pelo menos 8 caracteres',
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
