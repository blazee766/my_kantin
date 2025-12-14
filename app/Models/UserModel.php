<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'role_id',
        'name',
        'no_hp',
        'email',
        'password_hash',
        'is_active',
        'created_at',
        'updated_at',
        'wa_verified',
        'wa_verified_at',
    ];

    public function findByNoHp($no_hp)
    {
        return $this->where('no_hp', $no_hp)->first();
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
