<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddStockToMenus extends Migration
{
    public function up()
    {
        $this->forge->addColumn('menus', [
            'stock' => ['type'=>'INT','unsigned'=>true,'default'=>0,'after'=>'price'],
        ]);
    }
    public function down()
    {
        $this->forge->dropColumn('menus', 'stock');
    }
}
