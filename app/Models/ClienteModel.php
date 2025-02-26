<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'cpf';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['cpf', 'nome'];

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
        'cpf' => 'required|min_length[11]|max_length[11]|is_unique',
        'nome' => 'required'
    ];
    protected $validationMessages = [
        'cpf' => [
            'required' => 'O campo CPF é obrigatório.',
            'min_length' => 'O CPF deve ter exatamente 11 dígitos.',
            'max_length' => 'O CPF deve ter exatamente 11 dígitos.',
            'is_unique' => 'Este CPF já está cadastrado.'
        ],
        'nome' => [
            'required' => 'O campo Nome é obrigatório.'
        ]
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
