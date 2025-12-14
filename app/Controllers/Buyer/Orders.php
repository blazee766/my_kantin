<?php

namespace App\Controllers\Buyer;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use Dompdf\Dompdf;

class Orders extends BaseController
{
    private function mustLogin()
    {
        $user = session('user');
        if (!$user) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return $user;
    }

    private function autoUpdatePendingToProcessing(): void
    {
        
        $db = \Config\Database::connect();

        $limitTime = date('Y-m-d H:i:s', time() - (5 * 60));

        // UPDATE orders
        // SET status = 'processing'
        // WHERE status IN ('pending','menunggu')
        //   AND created_at <= $limitTime
        $db->table('orders')
            ->set('status', 'processing')
            ->whereIn('status', ['pending', 'menunggu'])
            ->where('created_at <=', $limitTime)
            ->update();
            
    }

    public function index()
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse)
            return $check;
        $user = $check;

        $this->autoUpdatePendingToProcessing();

        $orders = (new OrderModel())->getByUserWithAddress((int) $user['id']);

        return view('orders/index', [
            'orders' => $orders,
            'user' => $user,
        ]);
    }

    public function show($id)
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse)
            return $check;
        $user = $check;

        $this->autoUpdatePendingToProcessing();

        $orderModel = new OrderModel();
        $paymentModel = new PaymentModel();

        $order = $orderModel->getOneWithItemsWithAddress((int) $id, (int) $user['id']);
        if (!$order) {
            return redirect()->to(site_url('p/orders'))->with('error', 'Pesanan tidak ditemukan.');
        }

        $paymentStatus = $order['payment_status'] ?? 'unpaid';

        $payment = $paymentModel
            ->where('order_id', $order['id'])
            ->orderBy('id', 'DESC')
            ->first();

        if ($payment && $paymentStatus !== 'paid') {
            $paymentStatus = $payment['status'] ?? $paymentStatus;
        }

        return view('orders/show', [
            'order' => $order,
            'user' => $user,
            'payment' => $payment,
            'paymentStatus' => $paymentStatus,
        ]);
    }

    public function delete(int $id)
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse)
            return $check;
        $user = $check;

        $orderModel = new \App\Models\OrderModel();

        $order = $orderModel->getOneWithItems($id, (int) $user['id']);
        if (!$order) {
            return redirect()->to(site_url('p/orders'))->with('error', 'Pesanan tidak ditemukan.');
        }

        if (($order['status'] ?? '') === 'paid') {
            return redirect()->to(site_url('p/orders/' . $id))->with('error', 'Pesanan sudah dibayar dan tidak bisa dihapus.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($order['items'] ?? [] as $item) {
            $menuId = (int) ($item['menu_id'] ?? 0);
            $qty = (int) ($item['qty'] ?? 0);
            if ($menuId > 0 && $qty > 0) {
                $db->table('menus')->set('stock', "stock + {$qty}", false)->where('id', $menuId)->update();
            }
        }

        $db->table('order_items')->where('order_id', $id)->delete();
        $db->table('payments')->where('order_id', $id)->delete();
        $db->table('orders')->where('id', $id)->delete();
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(site_url('p/orders/' . $id))->with('error', 'Gagal menghapus pesanan (transaksi gagal).');
        }

        return redirect()->to(site_url('p/orders'))->with('success', 'Pesanan berhasil dihapus.');
    }
    public function nota(int $id)
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse)
            return $check;
        $user = $check;

        $orderModel = new \App\Models\OrderModel();
        $order = $orderModel->getOneWithItemsWithAddress($id, (int) $user['id']);
        if (!$order) {
            return redirect()->to(site_url('p/orders'))->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('orders/nota', [
            'order' => $order,
            'user' => $user,
        ]);
    }

    public function notaPdf(int $id)
    {
        // kalau ga mau PDF, hapus method ini atau biarkan tapi jangan pakai Dompdf
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse)
            return $check;
        $user = $check;

        $orderModel = new \App\Models\OrderModel();
        $order = $orderModel->getOneWithItemsWithAddress($id, (int) $user['id']);
        if (!$order) {
            return redirect()->to(site_url('p/orders'))->with('error', 'Pesanan tidak ditemukan.');
        }

        // require dompdf via composer
        $html = view('orders/nota_pdf', ['order' => $order, 'user' => $user]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A7', 'portrait'); // sesuaikan ukuran untuk thermal jika perlu
        $dompdf->render();
        $output = $dompdf->output();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', "inline; filename=nota_{$order['code']}.pdf")
            ->setBody($output);
    }
}
