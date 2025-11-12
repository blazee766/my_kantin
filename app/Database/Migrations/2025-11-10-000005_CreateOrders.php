<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'BIGINT','unsigned'=>true,'auto_increment'=>true],
            'user_id'=>['type'=>'INT','unsigned'=>true], // pembeli
            'code'=>['type'=>'VARCHAR','constraint'=>30,'unique'=>true],
            'status'=>['type'=>'ENUM','constraint'=>['pending','paid','processing','completed','cancelled'],'default'=>'pending'],
            'subtotal'=>['type'=>'INT','unsigned'=>true,'default'=>0],
            'discount'=>['type'=>'INT','unsigned'=>true,'default'=>0],
            'total'=>['type'=>'INT','unsigned'=>true,'default'=>0],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id','users','id','CASCADE','RESTRICT');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
