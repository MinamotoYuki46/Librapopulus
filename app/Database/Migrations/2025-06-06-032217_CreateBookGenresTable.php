<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookGenresTable extends Migration
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
                'unsigned' => true,
            ],
            'genre_id' => [
                'type' => 'INT',
                'unsigned' => true
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
        $this->forge->addForeignKey('book_id', 'book', 'id', 'CASCADE', 'CASCADE', 'fk_book');
        $this->forge->addForeignKey('genre_id', 'genres', 'id', 'CASCADE', 'CASCADE', 'fk_genre');
        $this->forge->addUniqueKey(['book_id', 'genre_id'], 'unique_key');
        $this->forge->createTable('book_genres');
    }

    public function down()
    {
        $this->forge->dropTable('book_genres');
    }
}
