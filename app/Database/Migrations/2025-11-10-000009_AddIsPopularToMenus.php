<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class AddIsPopularToMenus extends Migration
{
    public function up()
    {
        $this->forge->addColumn('menus', [
            'is_popular' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after'   => 'is_active'
            ],
        ]);
    }
    public function down()
    {
        $this->forge->dropColumn('menus', 'is_popular');
    }
}
