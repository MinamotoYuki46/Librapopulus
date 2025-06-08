<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationsTable extends Migration
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
                'unsigned' => true
            ],
            'sender_id' => [
                'type' => 'INT', 
                'unsigned' => true
            ],
            'type' => [
                'type' => 'VARCHAR', 
                'constraint' => '50'
            ],
            'related_id' => [
                'type' => 'INT', 
                'unsigned' => true, 
                'null' => true
            ],
            'message' => [
                'type' => 'VARCHAR', 
                'constraint' => '255'
            ],
            'read_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sender_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
