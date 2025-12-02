<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table         = 'payments';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'order_id',
        'method',
        'amount',
        'paid_at',
        'status',
        'notes',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = false;
}
