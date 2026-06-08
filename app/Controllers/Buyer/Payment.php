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
        $orderModel = new OrderModel();
        $orderModel->autoPromoteWaitingOrders();
        $order = $orderModel->getOneWithItems($orderId, (int)$u['id']);

        if (!$order) {
            return redirect()->to(site_url('p/orders'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        // Pesanan yang sudah diproses tetap boleh dibayar selama belum lunas.
        $statusKey = strtolower((string) ($order['status'] ?? 'pending'));
        if (!in_array($statusKey, ['pending', 'menunggu', 'processing', 'diproses'], true)) {
            return redirect()->to(site_url('p/orders/'.$orderId))
                ->with('error', 'Pesanan ini tidak bisa dibayar lagi.');
        }
        if (($order['payment_status'] ?? 'unpaid') === 'paid') {
            return redirect()->to(site_url('p/orders/'.$orderId))
                ->with('error', 'Pesanan ini sudah dibayar.');
        }

        return view('payment/qris', [
            'order' => $order,
        ]);
    }

    public function confirm($id)
    {
        $u = $this->userOrRedirect();
        if ($u instanceof \CodeIgniter\HTTP\RedirectResponse) return $u;

        $orderId = (int) $id;
        $orderModel = new OrderModel();
        $orderModel->autoPromoteWaitingOrders();
        $order = $orderModel->getOneWithItems($orderId, (int)$u['id']);

        if (!$order) {
            return redirect()->to(site_url('p/orders'))
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        if (($order['payment_status'] ?? 'unpaid') === 'paid') {
            return redirect()->to(site_url('p/orders/'.$orderId))
                ->with('success', 'Pesanan sudah dibayar.');
        }

        $proof = $this->request->getFile('payment_proof');
        if (!$proof || !$proof->isValid()) {
            return redirect()->to(site_url('p/payment/'.$orderId))
                ->with('error', 'Silakan upload gambar bukti pembayaran.');
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($proof->getMimeType(), $allowedTypes, true)) {
            return redirect()->to(site_url('p/payment/'.$orderId))
                ->with('error', 'Bukti pembayaran harus berupa gambar JPG, PNG, atau WEBP.');
        }

        if ($proof->getSizeByUnit('mb') > 3) {
            return redirect()->to(site_url('p/payment/'.$orderId))
                ->with('error', 'Ukuran bukti pembayaran maksimal 3 MB.');
        }

        $proofDir = FCPATH . 'assets/img/payment-proofs';
        if (!is_dir($proofDir)) {
            mkdir($proofDir, 0775, true);
        }

        $proofName = $proof->getRandomName();
        $proof->move($proofDir, $proofName);

        $orderModel->update($orderId, [
            'payment_status' => 'paid',
            'payment_method' => 'qris',
            'payment_type' => 'qris',
            'payment_proof' => 'assets/img/payment-proofs/' . $proofName,
        ]);

        return redirect()->to(site_url('p/orders/'.$orderId))
            ->with('success', 'Status pembayaran berhasil diubah menjadi Sudah Dibayar.');
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
