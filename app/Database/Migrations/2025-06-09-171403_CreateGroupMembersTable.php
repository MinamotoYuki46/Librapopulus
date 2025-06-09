<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupMembersTable extends Migration {
    public function up() {
        $this -> forge -> addField([
            'id'  => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'group_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'member'],
                'default'    => 'member',
            ],
            'joined_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        
        $this -> forge -> addKey('id', true);
        $this -> forge -> addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this -> forge -> addForeignKey('group_id', 'groups', 'id', 'CASCADE', 'CASCADE');
        $this -> forge -> addUniqueKey(['user_id', 'group_id']);
        $this -> forge -> createTable('group_members');
    }

    public function down() {
        $this -> forge -> dropTable('group_members');
    }
}