<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'BIGINT','unsigned'=>true,'auto_increment'=>true],
            'order_id'=>['type'=>'BIGINT','unsigned'=>true],
            'menu_id'=>['type'=>'INT','unsigned'=>true],
            'qty'=>['type'=>'INT','unsigned'=>true,'default'=>1],
            'price'=>['type'=>'INT','unsigned'=>true],
            'total'=>['type'=>'INT','unsigned'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id','orders','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('menu_id','menus','id','CASCADE','RESTRICT');
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
    }
}
