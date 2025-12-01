<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'user_id',
        'code',
        'total_amount',
        'status',
        'notes',
        'delivery_method',      
        'delivery_address_id',  
        'delivery_fee',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = false;

    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    public function getOneWithItems(int $orderId, int $userId): ?array
    {
        $order = $this->where('id', $orderId)
            ->where('user_id', $userId)
            ->first();
        if (!$order) {
            return null;
        }

        $items = model(\App\Models\OrderItemModel::class)
            ->where('order_id', $order['id'])
            ->findAll();

        $order['items'] = $items;

        return $order;
    }

    /**
     * Ambil 1 pesanan yang masih "menunggu/pending" milik user.
     * Ini yang akan kita gabung kalau user pesan lagi.
     */
    public function getPendingByUser(int $userId): ?array
    {
        return $this->where('user_id', $userId)
            ->whereIn('status', ['pending', 'menunggu'])
            ->orderBy('id', 'DESC')
            ->first();
    }
}
