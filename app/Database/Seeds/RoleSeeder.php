<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('roles')->insertBatch([
            ['name' => 'admin','created_at'=>date('Y-m-d H:i:s')],
            ['name' => 'pembeli','created_at'=>date('Y-m-d H:i:s')],
        ]);
    }
}
