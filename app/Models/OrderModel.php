<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'user_id','code','total_amount','status','notes','created_at','updated_at'
    ];
    protected $useTimestamps = false; // sesuaikan jika pakai timestamps

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
        if (!$order) return null;

        $items = model(OrderItemModel::class)
                    ->where('order_id', $order['id'])
                    ->findAll();

        // payment (optional)
        //$payment = model(PaymentModel::class)
                   // ->where('order_id', $order['id'])
                   // ->orderBy('id','DESC')
                    //->first();

        $order['items']   = $items;
        //$order['payment'] = $payment;

        return $order;
    }
}
