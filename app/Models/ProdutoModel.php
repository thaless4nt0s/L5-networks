<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nome', 'valor'];

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
        'nome' => 'required|min_length[3]|max_length[100]',
        'valor' => 'required|decimal|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.',
            'min_length' => 'O Nome deve ter pelo menos 3 caracteres.',
            'max_length' => 'O Nome deve ter no máximo 100 caracteres.'
        ],
        'valor' => [
            'required' => 'O campo Valor é obrigatório.',
            'decimal' => 'O Valor deve ser um número decimal.',
            'greater_than_equal_to' => 'O Valor deve ser maior ou igual a 0.'
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
