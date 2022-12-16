<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTransactionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'date' => [
                'type' => 'date',
            ],
            'description' => [
                'type' => 'TEXT',
                'constraint' => 500,
            ],
            'journal_description' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'created_by' => [
                'type'    => 'INT',
                'null' => true,
                'unsigned' => true,
            ],
            'updated_at' => [
                'type'           => 'TIMESTAMP',
                'null'           => true,
            ],
            'updated_by' => [
                'type'    => 'INT',
                'null' => true,
                'unsigned' => true,
            ],
            'deleted_at' => [
                'type'           => 'TIMESTAMP',
                'null'           => true,
            ],
            'deleted_by' => [
                'type'    => 'INT',
                'null' => true,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable("transactions");
    }

    public function down()
    {
        $this->forge->dropTable("transactions");
    }
}
