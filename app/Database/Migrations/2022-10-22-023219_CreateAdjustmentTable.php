<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateAdjustmentTable extends Migration
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
            'value' => [
                'type' => 'FLOAT',
                'constraint' => 12,
            ],
            'time' => [
                'type' => 'INT',
                'constraint' => 12,
            ],
            'total' => [
                'type' => 'INT',
                'constraint' => 12,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
                'unsigned' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
                'unsigned' => true,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_by' => [
                'type' => 'INT',
                'null' => true,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable("adjustments");
    }

    public function down()
    {
        $this->forge->dropTable("adjustments");
    }
}
