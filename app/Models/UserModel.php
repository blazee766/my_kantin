<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'role_id', 'name', 'npm', 'password_hash', 'is_active', 'created_at'
    ];

    public function findByNpm($npm)
    {
        return $this->where('npm', $npm)->first();
    }
}
