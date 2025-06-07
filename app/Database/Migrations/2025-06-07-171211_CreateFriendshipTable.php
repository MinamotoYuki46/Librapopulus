<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFriendshipTable extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_one_id' => [
                'type'           => 'INT',
                'unsigned'       => true
            ],
            'user_two_id' => [
                'type'           => 'INT',
                'unsigned'       => true
            ],
            'status' => [
                'type'           => 'TINYINT',
                'unsigned'       => true,
                'constraint'     => 1,
                'default'        => 0,
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
        $this->forge->addForeignKey('user_one_id', 'user', 'id', 'CASCADE', 'CASCADE', 'fk_user_one');
        $this->forge->addForeignKey('user_two_id', 'user', 'id', 'CASCADE', 'CASCADE', 'fk_user_two');
        $this->forge->createTable('friendships');
    }

    public function down()
    {
        $this->forge->dropTable('friendships');
    }
}
