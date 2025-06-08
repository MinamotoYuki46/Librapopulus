<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 
                'unsigned' => true, 
                'auto_increment' => true
            ],
            'sender_id' => [
                'type' => 'INT', 
                'unsigned' => true
            ],
            'receiver_id' => [
                'type' => 'INT', 
                'unsigned' => true
            ],
            'message_text' => [
                'type' => 'TEXT'
            ],
            'created_at' => [
                'type' => 'DATETIME', 
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('sender_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('receiver_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('messages');
    }

    public function down()
    {
        $this->forge->dropTable('messages');
    }
}
