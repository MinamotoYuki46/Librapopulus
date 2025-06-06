<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'author' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'book_cover' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'published_date' => [
                'type' => 'DATE',
                'null' => true
            ],
            'total_pages' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'description' => [
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
        $this->forge->addUniqueKey('slug', 'slug_key');
        $this->forge->createTable('book');
    }

    public function down()
    {
        $this->forge->dropTable('book');
    }
}
