<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUserProfile extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => false
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
            'country' => [
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
        $this->forge->addKey('user_id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE', 'fk_profile_user');
        $this->forge->createTable('profile');
    }

    public function down()
    {
        $this->forge->dropTable('profile');
    }
}
