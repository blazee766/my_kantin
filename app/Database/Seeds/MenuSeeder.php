<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // kategori default
        $this->db->table('menu_categories')->insert(['name'=>'Signature','created_at'=>date('Y-m-d H:i:s')]);
        $catId = $this->db->insertID();

        $now = Time::now()->toDateTimeString();
        $this->db->table('menus')->insertBatch([
            [
                'category_id'=>$catId,
                'name'=>'karee raitsu',
                'slug'=>'karee-raitsu',
                'description'=>'Rich and aromatic Japanese curry.',
                'price'=>24000,
                'image'=>'5.png',
                'created_at'=>$now
            ],
            [
                'category_id'=>$catId,
                'name'=>'bulgogi bowl',
                'slug'=>'bulgogi-bowl',
                'description'=>'Grilled marinated beef with rice.',
                'price'=>26000,
                'image'=>'4.png',
                'created_at'=>$now
            ],
            [
                'category_id'=>$catId,
                'name'=>'kimchi fried rice',
                'slug'=>'kimchi-fried-rice',
                'description'=>'Stir-fried rice with kimchi and vegetables.',
                'price'=>60000,
                'image'=>'2.png',
                'created_at'=>$now
            ],
            [
                'category_id'=>$catId,
                'name'=>'Crispy sambal matah',
                'slug'=>'crispy-sambal-matah',
                'description'=>'Crispy chicken with healthy vegetables.',
                'price'=>30000,
                'image'=>'1.png',
                'created_at'=>$now
            ],
        ]);
    }
}
