<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupMessagesTable extends Migration {
    public function up() {
        $this -> forge -> addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'group_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'sender_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'message_text' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => null
            ],
        ]);

        $this -> forge -> addKey('id', true);
        $this -> forge -> addForeignKey('group_id', 'groups', 'id', 'CASCADE', 'CASCADE');
        $this -> forge -> addForeignKey('sender_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this -> forge -> createTable('group_messages');
    }

    public function down() {
        $this -> forge -> dropTable('group_messages');
    }
}
