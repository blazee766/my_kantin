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
        'payment_status',
        'payment_method',
        'payment_type',
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

    public function getOneWithItemsWithAddress(int $orderId, int $userId): ?array
    {
        $order = $this->select(
            'orders.*, ua.building AS address_building, ua.room AS address_room, ua.note AS address_note'
        )
            ->join('user_addresses ua', 'ua.id = orders.delivery_address_id', 'left')
            ->where('orders.id', $orderId)
            ->where('orders.user_id', $userId)
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

    public function getAdminOneWithItemsWithAddress(int $orderId): ?array
    {
        $order = $this->select(
            'orders.*, ua.building AS address_building, ua.room AS address_room, ua.note AS address_note'
        )
            ->join('user_addresses ua', 'ua.id = orders.delivery_address_id', 'left')
            ->where('orders.id', $orderId)
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

    public function getPendingByUser(int $userId, ?string $deliveryMethod = null): ?array
    {
        $builder = $this->where('user_id', $userId)
            ->whereIn('status', ['pending', 'menunggu']);
            
        if ($deliveryMethod !== null) {
            $builder->where('delivery_method', $deliveryMethod);
        }

        return $builder->orderBy('id', 'DESC')->first();
    }


    public function getByUserWithAddress(int $userId): array
    {
        return $this->select(
            'orders.*, ua.building AS address_building, ua.room AS address_room, ua.note AS address_note'
        )
            ->join('user_addresses ua', 'ua.id = orders.delivery_address_id', 'left')
            ->where('orders.user_id', $userId)
            ->orderBy('id', 'DESC')
            ->findAll();
    }
}
