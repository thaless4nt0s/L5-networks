<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clientes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => "INT",
                'AUTO_INCREMENT' => true,
                'unsigned' => true
            ],
            'cpf' => [
                'type' => 'VARCHAR',
                'constraint' => '11'
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('cpf');
        $this->forge->createTable('clientes', true, ['engine' => 'innodb']);
    }

    public function down()
    {
        $this->forge->dropTable('clientes');
    }
}
