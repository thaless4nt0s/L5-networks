<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Administradores extends Migration
{
    public function up()
    {
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
                'type' => 'varchar',
                'constraint' => '70'
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('admins');
    }

    public function down()
    {
        $this->forge->dropTable('admins');
    }
}
