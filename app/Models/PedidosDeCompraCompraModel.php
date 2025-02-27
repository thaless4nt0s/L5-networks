<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidosDeCompraCompraModel extends Model
{
    protected $table = 'pedidosdecompracompras';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['dia', 'quantidade', 'valor_compra', 'idCliente', 'idProduto', 'status'];

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
        'dia' => 'required|valid_date', // Data válida
        'quantidade' => 'required|integer|greater_than[0]', // Número inteiro maior que 0
        'valor_compra' => 'required|decimal|greater_than[0]', // Número decimal maior que 0
        'idCliente' => 'required|integer|is_not_unique[clientes.id]', // Deve existir na tabela clientes
        'idProduto' => 'required|integer|is_not_unique[produtos.id]', // Deve existir na tabela produtos
        'status' => 'required|in_list[Em aberto,Pago,Cancelado]', // Valor permitido
    ];

    protected $validationMessages = [
        'dia' => [
            'required' => 'O campo Dia é obrigatório.',
            'valid_date' => 'O campo Dia deve ser uma data válida.'
        ],
        'quantidade' => [
            'required' => 'O campo Quantidade é obrigatório.',
            'integer' => 'O campo Quantidade deve ser um número inteiro.',
            'greater_than' => 'O campo Quantidade deve ser maior que 0.'
        ],
        'valor_compra' => [
            'required' => 'O campo Valor da Compra é obrigatório.',
            'decimal' => 'O campo Valor da Compra deve ser um número decimal.',
            'greater_than' => 'O campo Valor da Compra deve ser maior que 0.'
        ],
        'idCliente' => [
            'required' => 'O campo ID do Cliente é obrigatório.',
            'integer' => 'O campo ID do Cliente deve ser um número inteiro.',
            'is_not_unique' => 'O ID do Cliente informado não existe na tabela clientes.'
        ],
        'idProduto' => [
            'required' => 'O campo ID do Produto é obrigatório.',
            'integer' => 'O campo ID do Produto deve ser um número inteiro.',
            'is_not_unique' => 'O ID do Produto informado não existe na tabela produtos.'
        ],
        'status' => [
            'required' => 'O campo Status é obrigatório.',
            'in_list' => 'O campo Status deve ser "Em aberto", "Pago" ou "Cancelado".'
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
