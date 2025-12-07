<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserModel;

class Orders extends BaseController
{
    public function index()
    {
        $orderModel = model(OrderModel::class);
        $userModel  = model(UserModel::class);

        $orders = $orderModel
            ->select('orders.*, users.name as customer_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();

        return view('admin/orders/index', [
            'orders' => $orders,
        ]);
    }

    public function show($id)
    {
        $id         = (int) $id;
        $orderModel = model(OrderModel::class);
        $itemModel  = model(OrderItemModel::class);
        $userModel  = model(UserModel::class);

        $order = $orderModel
            ->select(
                'orders.*,
             users.name AS customer_name,
             ua.building AS address_building,
             ua.room     AS address_room,
             ua.note     AS address_note'
            )
            ->join('users', 'users.id = orders.user_id', 'left')
            ->join('user_addresses ua', 'ua.id = orders.delivery_address_id', 'left')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            return redirect()->to('/admin/orders')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        $items = $itemModel
            ->where('order_id', $id)
            ->findAll();

        return view('admin/orders/show', [
            'order' => $order,
            'items' => $items,
        ]);
    }


    public function updateStatus($id)
    {
        $id     = (int) $id;
        $status = $this->request->getPost('status');

        $allowed = ['pending', 'processing', 'completed', 'canceled'];

        if (!in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Status tidak dikenal.');
        }

        $orderModel = model(OrderModel::class);
        $order      = $orderModel->find($id);

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $orderModel->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
    public function markPaid($id)
    {
        $id = (int) $id;

        $orderModel = model(OrderModel::class);
        $order      = $orderModel->find($id);

        if (! $order) {
            return redirect()->to('/admin/orders')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order['status'] === 'canceled') {
            return redirect()->back()
                ->with('error', 'Pesanan yang dibatalkan tidak bisa ditandai sudah dibayar.');
        }

        $orderModel->update($id, [
            'payment_status' => 'paid',
            // kalau di tabel ada kolom ini, boleh diisi juga:
            // 'payment_method' => 'cash',
            // 'paid_at'        => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()
            ->with('success', 'Pembayaran ditandai sudah dibayar (tunai).');
    }
}
