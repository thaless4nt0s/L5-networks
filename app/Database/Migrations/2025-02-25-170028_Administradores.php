<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Administradores extends Migration
{
    public function up()
    {
        // Definir os campos da tabela
        $this->forge->addField([
            'id' => [
                'type' => "INT",
                'AUTO_INCREMENT' => true,
                'unsigned' => true
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'email' => [
                'type' => 'VARCHAR', // Alterado para maiúsculo para consistência
                'constraint' => '70'
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => '255' // Aumentado para suportar hashes de senha
            ]
        ]);

        // Adicionar chave primária
        $this->forge->addPrimaryKey('id');

        // Adicionar chave única para o campo email
        $this->forge->addUniqueKey('email');

        // Criar a tabela com codificação UTF-8
        $this->forge->createTable('admins', true, [
            'ENGINE' => 'InnoDB', // Usar InnoDB para suportar chaves estrangeiras e transações
            'CHARACTER SET' => 'utf8mb4', // Usar utf8mb4 para suportar todos os caracteres Unicode
            'COLLATE' => 'utf8mb4_unicode_ci' // Collation que suporta caracteres especiais
        ]);
    }

    public function down()
    {
        // Remover a tabela se a migração for revertida
        $this->forge->dropTable('admins');
    }
}