<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Users extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'=> [
                'type'=>'INT',
                'constraint' => 11,
                'unsigned'=> true,
                'auto_increment' => true
            ],
            'login' => [
                'type' => 'VARBINARY',
                'constraint' => 200,
                'null' => true

            ],
            'passwrd' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true

            ],
            'profile' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'blocked_until' => [
                'type' => 'DATETIME',                
                'null' => true
            ],
            'create_at' => [
                'type' => 'DATETIME',                
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'update_at' => [
                'type' => 'DATETIME',                
                'null' => true
            ],
            'delete_at' => [
                'type' => 'DATETIME',                
                'null' => true
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_users');
    }

    public function down()
    {
        //
        $this->forge->dropTable('tb_users');
    }
}
