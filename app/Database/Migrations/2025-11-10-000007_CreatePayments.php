<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePayments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'BIGINT','unsigned'=>true,'auto_increment'=>true],
            'order_id'=>['type'=>'BIGINT','unsigned'=>true],
            'method'=>['type'=>'VARCHAR','constraint'=>50], // e.g. cash, qris, transfer
            'amount'=>['type'=>'INT','unsigned'=>true],
            'paid_at'=>['type'=>'DATETIME','null'=>true],
            'status'=>['type'=>'ENUM','constraint'=>['unpaid','paid','failed'],'default'=>'unpaid'],
            'notes'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id','orders','id','CASCADE','CASCADE');
        $this->forge->createTable('payments');
    }

    public function down()
    {
        $this->forge->dropTable('payments');
    }
}
