<?php
namespace App\Controllers\Buyer;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;

class Checkout extends BaseController
{
    protected function getCart(): array
    {
        return session()->get('cart') ?? [];
    }

    public function index()
    {
        $cart = $this->getCart();
        if (empty($cart)) return redirect()->to('/cart/')->with('error','Keranjang kosong.');
        $subtotal = array_sum(array_column($cart,'total'));
        $discount = 0;
        $total    = max(0, $subtotal - $discount);
        return view('buyer/checkout', compact('cart','subtotal','discount','total'));
    }

    public function placeOrder()
    {
        $user = session('user');
        $cart = $this->getCart();
        if (!$user) return redirect()->to('/login')->with('error','Silakan login.');
        if (empty($cart)) return redirect()->to('/cart/')->with('error','Keranjang kosong.');

        $method   = $this->request->getPost('method') ?: 'cash';
        $subtotal = array_sum(array_column($cart,'total'));
        $discount = 0;
        $total    = max(0, $subtotal - $discount);

        $db = db_connect();
        $db->transStart(); 

        // (1) Validasi & KURANGI STOK atomik
        foreach ($cart as $row) {
            $qty    = (int)$row['qty'];
            $menuId = (int)$row['id'];

            $db->table('menus')
               ->set('stock', "stock - {$qty}", false)
               ->where('id', $menuId)
               ->where('stock >=', $qty)
               ->update();

            if ($db->affectedRows() === 0) {
                $db->transRollback();
                return redirect()->to('/cart/')
                   ->with('error', "Stok untuk '{$row['name']}' tidak mencukupi.")
                   ->withInput();
            }
        }

        // (2) Buat order & item
        $orders  = new OrderModel();
        $orderId = $orders->insert([
            'user_id'   => $user['id'],
            'code'      => $orders->generateCode(),
            'status'    => 'pending',      
            'subtotal'  => $subtotal,
            'discount'  => $discount,
            'total'     => $total,
            'created_at'=> date('Y-m-d H:i:s')
        ]);

        $items = [];
        foreach ($cart as $r) {
            $items[] = [
                'order_id' => $orderId,
                'menu_id'  => $r['id'],
                'qty'      => $r['qty'],
                'price'    => $r['price'],
                'total'    => $r['total'],
            ];
        }
        model(OrderItemModel::class)->insertBatch($items);

        // (3) Buat payment
        model(PaymentModel::class)->insert([
            'order_id'  => $orderId,
            'method'    => $method,
            'amount'    => $total,
            'status'    => 'paid',
            'paid_at'   => date('Y-m-d H:i:s'),
            'created_at'=> date('Y-m-d H:i:s')
        ]);
        $orders->update($orderId, ['status'=>'paid']);

        $db->transComplete(); 

        session()->remove('cart');
        return redirect()->to('/orders/'.$orderId)->with('success','Pesanan berhasil dibuat!');
    }
}
