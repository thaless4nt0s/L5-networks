<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PedidosDeCompra extends Migration
{
    public function up()
    {
        // Define a estrutura da tabela 'pedidos_de_compra'
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true, // ID autoincrementável
            ],
            'dia' => [
                'type' => 'DATE', // Data do pedido
                'null' => false, // Campo obrigatório
            ],
            'quantidade' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false, // Campo obrigatório
            ],
            'valor_compra' => [
                'type' => 'DECIMAL', // Valor total da compra
                'constraint' => '10,2', // 10 dígitos no total, 2 casas decimais
                'null' => false, // Campo obrigatório
            ],
            'idCliente' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true, // Chave estrangeira para a tabela 'clientes'
                'null' => false, // Campo obrigatório
            ],
            'idProduto' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true, // Chave estrangeira para a tabela 'produtos'
                'null' => false, // Campo obrigatório
            ],
            'status' => [
                'type' => 'ENUM', // Tipo ENUM para valores específicos
                'constraint' => ['Em aberto', 'Pago', 'Cancelado'], // Valores permitidos
                'default' => 'Em aberto', // Valor padrão
                'null' => false, // Campo obrigatório
            ],
        ]);

        // Define a chave primária
        $this->forge->addPrimaryKey('id');

        // Define as chaves estrangeiras
        $this->forge->addForeignKey('idCliente', 'clientes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idProduto', 'produtos', 'id', 'CASCADE', 'CASCADE');

        // Cria a tabela 'pedidos_de_compra'
        $this->forge->createTable('pedidos_de_compra');
    }

    public function down()
    {
        // Remove a tabela 'pedidos_de_compra' se existir
        $this->forge->dropTable('pedidos_de_compra');
    }
}