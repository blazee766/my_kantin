<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAddressModel extends Model
{
    protected $table         = 'user_addresses';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'user_id',
        'building',
        'room',
        'note',
        'is_default',
        'created_at',
    ];
    public $timestamps = false;
}
