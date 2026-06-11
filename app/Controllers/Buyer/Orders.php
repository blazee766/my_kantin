<?php

namespace App\Controllers\Buyer;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use Dompdf\Dompdf;

class Orders extends BaseController
{
    private function isAjaxRequest(): bool
    {
        return $this->request->isAJAX()
            || str_contains((string) $this->request->getHeaderLine('Accept'), 'application/json');
    }

    private function jsonOrRedirect(array $payload, string $redirectTo, string $flashType = 'success', int $statusCode = 200)
    {
        if ($this->isAjaxRequest()) {
            if (function_exists('csrf_token') && function_exists('csrf_hash')) {
                $payload['csrfTokenName'] = csrf_token();
                $payload['csrfHash'] = csrf_hash();
            }
            return $this->response->setStatusCode($statusCode)->setJSON($payload);
        }

        return redirect()->to($redirectTo)->with($flashType, $payload['message'] ?? $payload['msg'] ?? '');
    }

    private function mustLogin()
    {
        $user = session('user');
        if (!$user) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return $user;
    }

    private function statusPayload(string $status): array
    {
        $statusKey = strtolower($status);

        $labelMap = [
            'pending'    => 'Menunggu',
            'menunggu'   => 'Menunggu',
            'processing' => 'Diproses',
            'diproses'   => 'Diproses',
            'completed'  => 'Selesai',
            'selesai'    => 'Selesai',
            'canceled'   => 'Batal',
            'batal'      => 'Batal',
        ];

        $classMap = [
            'pending'    => 'pending',
            'menunggu'   => 'pending',
            'processing' => 'pending',
            'diproses'   => 'pending',
            'completed'  => 'paid',
            'selesai'    => 'paid',
            'canceled'   => 'cancel',
            'batal'      => 'cancel',
        ];

        return [
            'status'      => $status,
            'statusLabel' => $labelMap[$statusKey] ?? ucfirst($status),
            'statusClass' => $classMap[$statusKey] ?? 'pending',
        ];
    }

    public function index()
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse)
            return $check;
        $user = $check;

        $orderModel = new OrderModel();
        $orderModel->autoPromoteWaitingOrders();
        $orders = $orderModel->getByUserWithAddress((int) $user['id']);

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

        $orderModel = new OrderModel();
        $paymentModel = new PaymentModel();

        $orderModel->autoPromoteWaitingOrders();
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

    public function checkStatus($id)
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $this->response->setStatusCode(401)->setJSON([
                'ok' => false,
                'message' => 'Silakan login terlebih dahulu.',
            ]);
        }
        $user = $check;

        $orderModel = new OrderModel();
        $orderModel->autoPromoteWaitingOrders();
        $order = $orderModel->getOneWithItems((int) $id, (int) $user['id']);

        if (!$order) {
            return $this->response->setStatusCode(404)->setJSON([
                'ok' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ]);
        }

        return $this->response->setJSON([
            'ok' => true,
        ] + $this->statusPayload((string) ($order['status'] ?? 'pending')));
    }

    public function removeItem(int $orderId, int $menuId)
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $check;
        }
        $user = $check;

        $orderModel = new OrderModel();
        $orderModel->autoPromoteWaitingOrders();
        $order = $orderModel->getOneWithItems($orderId, (int) $user['id']);

        if (!$order) {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], site_url('p/orders'), 'error', 404);
        }

        $statusKey = strtolower((string) ($order['status'] ?? 'pending'));
        if (!in_array($statusKey, ['pending', 'menunggu', 'processing', 'diproses'], true)) {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Item pesanan ini tidak bisa dihapus lagi.',
            ], site_url('p/orders/' . $orderId), 'error', 422);
        }

        $db = \Config\Database::connect();
        $item = $db->table('order_items')
            ->where('order_id', $orderId)
            ->where('menu_id', $menuId)
            ->where('qty >', 0)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();

        if (!$item) {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Item pesanan tidak ditemukan.',
            ], site_url('p/orders/' . $orderId), 'error', 404);
        }

        $price = (int) ($item['price'] ?? 0);
        $qty = (int) ($item['qty'] ?? 0);

        $db->transStart();

        if ($qty > 1) {
            $db->table('order_items')
                ->set('qty', 'qty - 1', false)
                ->set('subtotal', 'GREATEST(subtotal - ' . $price . ', 0)', false)
                ->where('id', (int) $item['id'])
                ->update();
        } else {
            $db->table('order_items')
                ->where('id', (int) $item['id'])
                ->delete();
        }

        $db->table('menus')
            ->set('stock', 'stock + 1', false)
            ->where('id', $menuId)
            ->update();

        $db->table('orders')
            ->set('total_amount', 'GREATEST(total_amount - ' . $price . ', 0)', false)
            ->where('id', $orderId)
            ->where('user_id', (int) $user['id'])
            ->update();

        $remaining = $db->table('order_items')
            ->select('COUNT(*) AS total')
            ->where('order_id', $orderId)
            ->get()
            ->getRowArray();

        if ((int) ($remaining['total'] ?? 0) === 0) {
            $db->table('payments')->where('order_id', $orderId)->delete();
            $db->table('orders')->where('id', $orderId)->delete();
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Gagal menghapus item pesanan.',
            ], site_url('p/orders/' . $orderId), 'error', 500);
        }

        if ((int) ($remaining['total'] ?? 0) === 0) {
            return $this->jsonOrRedirect([
                'ok' => true,
                'message' => 'pesanan berhasil dihapus',
                'removedOrder' => true,
                'redirect' => site_url('p/orders'),
            ], site_url('p/orders'));
        }

        $newTotal = $db->table('orders')
            ->select('total_amount')
            ->where('id', $orderId)
            ->get()
            ->getRowArray();

        $newQty = $qty > 1 ? $qty - 1 : 0;

        return $this->jsonOrRedirect([
            'ok' => true,
            'message' => '1 item berhasil dihapus dari pesanan.',
            'menuId' => $menuId,
            'qty' => $newQty,
            'rowRemoved' => $newQty === 0,
            'lineSubtotal' => max(($qty - 1) * $price, 0),
            'totalAmount' => (int) ($newTotal['total_amount'] ?? 0),
        ], site_url('p/orders/' . $orderId));
    }

    public function delete(int $id)
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse)
            return $check;
        $user = $check;

        $orderModel = new \App\Models\OrderModel();

        $orderModel->autoPromoteWaitingOrders();
        $order = $orderModel->getOneWithItems($id, (int) $user['id']);
        if (!$order) {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], site_url('p/orders'), 'error', 404);
        }

        $statusKey = strtolower((string) ($order['status'] ?? 'pending'));
        if (!in_array($statusKey, ['pending', 'menunggu'], true)) {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Pesanan yang sudah diproses tidak bisa dihapus.',
            ], site_url('p/orders/' . $id), 'error', 422);
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
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Gagal menghapus pesanan (transaksi gagal).',
            ], site_url('p/orders/' . $id), 'error', 500);
        }

        return $this->jsonOrRedirect([
            'ok' => true,
            'message' => 'pesanan berhasil dihapus',
            'removedOrder' => true,
            'redirect' => site_url('p/orders'),
        ], site_url('p/orders'));
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
