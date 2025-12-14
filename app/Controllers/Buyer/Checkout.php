<?php

namespace App\Controllers\Buyer;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Checkout extends BaseController
{
    protected function getCart(): array
    {
        return session()->get('cart') ?? [];
    }

    public function index()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->to('/cart/')->with('error', 'Keranjang kosong.');
        }

        $subtotal = array_sum(array_column($cart, 'total'));
        $discount = 0;
        $total    = max(0, $subtotal - $discount);

        return view('buyer/checkout', compact('cart', 'subtotal', 'discount', 'total'));
    }

    public function placeOrder()
    {
        if (empty($user['wa_verified'])) {
            return redirect()->to('/register')
                ->with('error', 'Silakan verifikasi nomor WhatsApp terlebih dahulu sebelum melakukan pemesanan.');
        }

        $user = session('user');
        $cart = $this->getCart();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Silakan login.');
        }
        if (empty($cart)) {
            return redirect()->to('/cart/')->with('error', 'Keranjang kosong.');
        }

        $cartTotal = (int) array_sum(array_column($cart, 'total'));

        $deliveryMethod = $this->request->getPost('delivery_method');

        if (! in_array($deliveryMethod, ['pickup', 'delivery'], true)) {
            $deliveryMethod = session('delivery_method') ?? 'pickup';
        }

        $db     = db_connect();
        $orders = new OrderModel();

        $pendingId     = (int) (session()->get('current_pending_order_id') ?? 0);
        $existingOrder = null;

        if ($pendingId > 0) {
            $existingOrder = $orders->where('id', $pendingId)
                ->where('user_id', $user['id'])
                ->whereIn('status', ['pending', 'menunggu'])
                ->first();
        }

        if (!$existingOrder) {
            $existingOrder = $orders->getPendingByUser((int) $user['id']);
        }

        $db->transStart();

        foreach ($cart as $row) {
            $qty    = (int) $row['qty'];
            $menuId = (int) $row['id'];

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

        if ($existingOrder) {

            $orderId = (int) $existingOrder['id'];
            $orders->increaseTotalAmount($orderId, $cartTotal);
            $orders->update($orderId, [           
                'updated_at'      => date('Y-m-d H:i:s'),
                'delivery_method' => $deliveryMethod,
            ]);
        } else {
            $orderId = $orders->insert([
                'user_id'         => $user['id'],
                'code'            => $orders->generateCode(),   
                'status'          => 'menunggu',               
                'total_amount'    => $cartTotal,
                'delivery_method' => $deliveryMethod,           
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
        }

        session()->set('current_pending_order_id', $orderId);

        $items = [];
        foreach ($cart as $r) {
            $items[] = [
                'order_id' => $orderId,
                'menu_id'  => $r['id'],
                'name'     => $r['name'] ?? '',
                'qty'      => $r['qty'],
                'price'    => $r['price'],
                'subtotal' => $r['total'],   
            ];
        }
        model(OrderItemModel::class)->insertBatch($items);
        $db->transComplete();
        session()->remove('cart');

        return redirect()->to(site_url('p/orders/' . $orderId))
            ->with('success', 'Pesanan berhasil dibuat / diperbarui!');
    }
}
