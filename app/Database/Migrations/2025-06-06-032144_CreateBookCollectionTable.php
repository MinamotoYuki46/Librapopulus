<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookCollectionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'book_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'read_page' => [
                'type'       => 'INT',
                'unsigned' => true,
                'null' => true
            ],
            'rating' => [
                'type' => 'TINYINT',
                'unsigned' => true,
                'null' => true
            ],
            'review' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE', 'fk_collection_user');
        $this->forge->addForeignKey('book_id', 'book', 'id', 'CASCADE', 'CASCADE', 'fk_collection_book');
        $this->forge->createTable('book_collection');
    }

    public function down()
    {
        $this->forge->dropTable('book_collection');
    }
}
