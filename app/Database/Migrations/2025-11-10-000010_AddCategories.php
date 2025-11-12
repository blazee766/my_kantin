<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategories extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        /** @var \CodeIgniter\Database\BaseConnection $db */

        // 1) Buat tabel categories jika belum ada
        if (! $db->tableExists('categories')) {
            $this->forge->addField([
                'id'   => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
                'name' => ['type'=>'VARCHAR','constraint'=>50],
                'slug' => ['type'=>'VARCHAR','constraint'=>50],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('categories', true);
        }

        // 2) Tambah kolom category_id ke menus jika belum ada
        if (! $db->fieldExists('category_id', 'menus')) {
            $this->forge->addColumn('menus', [
                'category_id' => ['type'=>'INT','unsigned'=>true,'null'=>true,'after'=>'id'],
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        /** @var \CodeIgniter\Database\BaseConnection $db */

        if ($db->fieldExists('category_id', 'menus')) {
            $this->forge->dropColumn('menus', 'category_id');
        }
        if ($db->tableExists('categories')) {
            $this->forge->dropTable('categories', true);
        }
    }
}
