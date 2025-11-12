<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'category_id'=>['type'=>'INT','unsigned'=>true,'null'=>true],
            'name'=>['type'=>'VARCHAR','constraint'=>150],
            'slug'=>['type'=>'VARCHAR','constraint'=>160,'unique'=>true],
            'description'=>['type'=>'TEXT','null'=>true],
            'price'=>['type'=>'INT','unsigned'=>true], // simpan dalam rupiah
            'image'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'is_active'=>['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('category_id','menu_categories','id','SET NULL','RESTRICT');
        $this->forge->createTable('menus');
    }

    public function down()
    {
        $this->forge->dropTable('menus');
    }
}
