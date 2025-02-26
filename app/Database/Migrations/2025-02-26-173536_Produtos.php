<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produtos extends Migration
{
    public function up()
    {
        // Define a estrutura da tabela 'produtos'
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true, // ID autoincrementável
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 100, // Nome do produto (máximo 100 caracteres)
                'null' => false, // Campo obrigatório
            ],
            'valor' => [
                'type' => 'DECIMAL', // Valor do produto (usamos DECIMAL para valores monetários)
                'constraint' => '10,2', // 10 dígitos no total, 2 casas decimais
                'null' => false, // Campo obrigatório
            ],
        ]);

        // Define a chave primária
        $this->forge->addPrimaryKey('id');

        // Cria a tabela 'produtos'
        $this->forge->createTable('produtos');
    }

    public function down()
    {
        // Remove a tabela 'produtos' se existir
        $this->forge->dropTable('produtos');
    }
}