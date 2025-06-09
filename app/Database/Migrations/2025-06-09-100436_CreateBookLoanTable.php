<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookLoanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 
                'unsigned' => true, 
                'auto_increment' => true
            ],
            'book_id' => [
                'type' => 'INT', 
                'unsigned' => true
            ],
            'lender_id' => [
                'type' => 'INT', 
                'unsigned' => true
            ],
            'borrower_id' => [
                'type' => 'INT', 
                'unsigned' => true
            ],
            'loan_start_date' => [
                'type' => 'DATE'
            ],
            'loan_end_date' => [
                'type' => 'DATE'
            ],
            'status' => [
                'type' => 'TINYINT', 
                'constraint' => 1, 
                'default' => 0
            ],
            'approved_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
            'returned_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('book_id', 'book', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lender_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('borrower_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('book_loans');
    }

    public function down()
    {
        $this->forge->dropTable('book_loans');
    }
}
