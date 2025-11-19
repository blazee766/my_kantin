<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Orders extends BaseController
{
    public function index()
    {
        $uid = (int) session('user.id');
        $orders = (new OrderModel())
            ->where('user_id',$uid)
            ->orderBy('id','DESC')
            ->findAll();

        return view('buyer/orders/index', compact('orders'));
    }

    public function show($id)
    {
        $uid   = (int) session('user.id');
        $order = (new OrderModel())->withItems((int)$id);

        if (!$order || (int)$order['user_id'] !== $uid) {
            return redirect()->to('/orders')->with('error','Pesanan tidak ditemukan.');
        }

        return view('buyer/orders/show', compact('order'));
    }
}
