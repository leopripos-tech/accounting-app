<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTransactionItemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'transaction_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'account_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'status_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'debit' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'credit' => [
                'type' => 'INT',
                'unsigned' => true,
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
        $this->forge->addForeignKey("transaction_id", "transactions", "id", 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey("status_id", "transaction_statuses", "id");
        
        $this->forge->createTable("transaction_items");
    }

    public function down()
    {
        $this->forge->dropTable("transaction_items");
    }
}
