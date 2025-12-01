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
        $user = session('user');
        $cart = $this->getCart();

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Silakan login.');
        }
        if (empty($cart)) {
            return redirect()->to('/cart/')->with('error', 'Keranjang kosong.');
        }

        // --- TOTAL dari keranjang sekarang ---
        $cartTotal = (int) array_sum(array_column($cart, 'total'));

        // ambil pilihan metode pengambilan
        $deliveryMethod = $this->request->getPost('delivery_method');

        if (! in_array($deliveryMethod, ['pickup', 'delivery'], true)) {
            // kalau tidak ada di POST, pakai yang tersimpan di session (dari Cart::add)
            $deliveryMethod = session('delivery_method') ?? 'pickup';
        }

        $db     = db_connect();
        $orders = new OrderModel();

        // ===== 1. Cari order pending dari SESSION dulu =====
        $pendingId     = (int) (session()->get('current_pending_order_id') ?? 0);
        $existingOrder = null;

        if ($pendingId > 0) {
            $existingOrder = $orders->where('id', $pendingId)
                ->where('user_id', $user['id'])
                ->whereIn('status', ['pending', 'menunggu'])
                ->first();
        }

        // ===== 2. Kalau nggak ketemu di session → cek DB biasa =====
        if (!$existingOrder) {
            $existingOrder = $orders->getPendingByUser((int) $user['id']);
        }

        $db->transStart();

        // (A) Validasi & KURANGI STOK atomik
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

        // (B) BUAT / UPDATE ORDER
        if ($existingOrder) {
            // === SUDAH ADA PESANAN MENUNGGU → GABUNGKAN ===
            $orderId = (int) $existingOrder['id'];

            // Tambah total_amount dengan nilai dari keranjang baru
            $orders->increaseTotalAmount($orderId, $cartTotal);

            // update updated_at + simpan metode pengantaran terbaru
            $orders->update($orderId, [           // <-- diubah
                'updated_at'      => date('Y-m-d H:i:s'),
                'delivery_method' => $deliveryMethod,
            ]);
        } else {
            // === BELUM ADA → BUAT PESANAN BARU ===
            $orderId = $orders->insert([
                'user_id'         => $user['id'],
                'code'            => $orders->generateCode(),   // fungsi yang sudah kamu punya
                'status'          => 'menunggu',                // konsisten: pakai "menunggu"
                'total_amount'    => $cartTotal,
                'delivery_method' => $deliveryMethod,           // <-- tambahan
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
        }

        // Simpan id order pending di session supaya request berikutnya tahu harus digabung
        session()->set('current_pending_order_id', $orderId);

        // (C) SIMPAN ITEM KE order_items (SELALU TAMBAH BARU)
        $items = [];
        foreach ($cart as $r) {
            $items[] = [
                'order_id' => $orderId,
                'menu_id'  => $r['id'],
                'name'     => $r['name'] ?? '',
                'qty'      => $r['qty'],
                'price'    => $r['price'],
                'subtotal' => $r['total'],     // mapping ke kolom subtotal
            ];
        }
        model(OrderItemModel::class)->insertBatch($items);

        // (D) Tidak buat payment di sini → status tetap "menunggu",
        //     nanti admin/kasir yang ubah.

        $db->transComplete();

        // kosongkan keranjang
        session()->remove('cart');

        // redirect ke detail pesanan (namespace Buyer, prefix "p")
        return redirect()->to(site_url('p/orders/' . $orderId))
            ->with('success', 'Pesanan berhasil dibuat / diperbarui!');
    }
}
