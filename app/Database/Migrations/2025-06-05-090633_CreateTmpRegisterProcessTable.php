<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTmpRegisterProcessTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'favorite_genres' => [
                'type' => 'JSON',
                'null' => true
            ],
            'picture' => [
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
        $this->forge->createTable('tmp_register_process');
    }

    public function down()
    {
        $this->forge->dropTable('tmp_register_process');
    }
}
