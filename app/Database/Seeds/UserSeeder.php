<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $roles = $this->db->table('roles')->get()->getResultArray();
        $roleMap = array_column($roles, 'id', 'name');

        $this->db->table('users')->insertBatch([
            [
                'role_id' => $roleMap['admin'],
                'name' => 'Admin Kantin',
                'email' => 'admin@kantin.local',
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'created_at'=>date('Y-m-d H:i:s')
            ],
            [
                'role_id' => $roleMap['pembeli'],
                'name' => 'Budi Pembeli',
                'email' => 'budi@kantin.local',
                'password_hash' => password_hash('budi123', PASSWORD_BCRYPT),
                'created_at'=>date('Y-m-d H:i:s')
            ],
        ]);
    }
}
