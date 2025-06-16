<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'book_loan_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('book_loan_id', 'book_loans', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('report');
    }

    public function down()
    {
        $this->forge->dropTable('report');
    }
}
