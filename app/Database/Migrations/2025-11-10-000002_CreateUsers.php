<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'role_id' => ['type'=>'INT','unsigned'=>true],
            'name'  => ['type'=>'VARCHAR','constraint'=>100],
            'no_hp'  => ['type'=>'VARCHAR','constraint'=>12],
            'email' => ['type'=>'VARCHAR','constraint'=>191,'unique'=>true,'null'=>true],
            'password_hash' => ['type'=>'VARCHAR','constraint'=>255],
            'is_active' => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id','roles','id','CASCADE','RESTRICT');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
