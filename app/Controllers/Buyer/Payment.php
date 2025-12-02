<?php

namespace App\Controllers\Buyer;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Payment extends BaseController
{
    private function userOrRedirect()
    {
        $u = session('user');
        if (!$u) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return $u;
    }

    public function pay($id)
    {
        $u = $this->userOrRedirect();
        if ($u instanceof \CodeIgniter\HTTP\RedirectResponse) return $u;

        $orderId = (int) $id;
        $order   = (new OrderModel())->getOneWithItems($orderId, (int)$u['id']);

        if (!$order) {
            return redirect()->to(site_url('p/orders'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        // Hanya boleh bayar kalau status order masih pending & belum dibayar
        if (!in_array($order['status'], ['pending','menunggu'], true)) {
            return redirect()->to(site_url('p/orders/'.$orderId))
                ->with('error', 'Pesanan ini tidak bisa dibayar lagi.');
        }
        if (($order['payment_status'] ?? 'unpaid') === 'paid') {
            return redirect()->to(site_url('p/orders/'.$orderId))
                ->with('error', 'Pesanan ini sudah dibayar.');
        }

        // ==== Konfigurasi Midtrans ====
        \Midtrans\Config::$serverKey    = getenv('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = getenv('MIDTRANS_IS_PRODUCTION') === 'true';
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $transactionDetails = [
            'order_id'     => $order['code'],                 // gunakan kode order kamu
            'gross_amount' => (int) $order['total_amount'],   // total bayar
        ];

        $customer = $u;
        $customerDetails = [
            'first_name' => $customer['name']  ?? 'Customer',
            'email'      => $customer['email'] ?? null,
            'phone'      => $customer['phone'] ?? null,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details'    => $customerDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat transaksi Midtrans: '.$e->getMessage());
        }

        return view('buyer/payment_snap', [
            'order'     => $order,
            'snapToken' => $snapToken,
            'clientKey' => getenv('MIDTRANS_CLIENT_KEY'),
        ]);
    }

    // === Endpoint notifikasi dari Midtrans ===
    public function notification()
    {
        $json  = $this->request->getBody();
        $notif = json_decode($json, true);

        if (!$notif) {
            return $this->response->setStatusCode(400, 'Invalid JSON');
        }

        $orderCode   = $notif['order_id']           ?? null;
        $statusTrans = $notif['transaction_status'] ?? null;
        $paymentType = $notif['payment_type']       ?? null;

        if (!$orderCode) {
            return $this->response->setStatusCode(400, 'No order id');
        }

        $orderModel = new OrderModel();
        $order      = $orderModel->where('code', $orderCode)->first();

        if (!$order) {
            return $this->response->setStatusCode(404, 'Order not found');
        }

        // Mapping status Midtrans -> status & payment_status di sistem kamu
        $dataUpdate = [
            'payment_method' => 'midtrans',
            'payment_type'   => $paymentType,
        ];

        if (in_array($statusTrans, ['capture','settlement'], true)) {
            $dataUpdate['payment_status'] = 'paid';
            // kalau mau sekaligus dianggap selesai bayar:
            // $dataUpdate['status'] = 'completed';
        }
        elseif (in_array($statusTrans, ['expire','cancel','deny'], true)) {
            $dataUpdate['payment_status'] = 'failed';
            // $dataUpdate['status'] = 'canceled';
        }

        $orderModel->update($order['id'], $dataUpdate);

        return $this->response->setStatusCode(200);
    }
}
