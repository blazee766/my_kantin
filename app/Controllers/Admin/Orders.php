<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\MenuModel;
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
            return $this->response->setStatusCode($statusCode)->setJSON($this->withCsrf($payload));
        }

        return redirect()->to($redirectTo)->with($flashType, $payload['message'] ?? $payload['msg'] ?? '');
    }

    private function withCsrf(array $payload): array
    {
        if (function_exists('csrf_token') && function_exists('csrf_hash')) {
            $payload['csrfTokenName'] = csrf_token();
            $payload['csrfHash'] = csrf_hash();
        }

        return $payload;
    }

    private function statusPayload(string $status): array
    {
        $labelMap = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'canceled' => 'Batal',
        ];

        $classMap = [
            'pending' => 'wait',
            'processing' => 'proc',
            'completed' => 'done',
            'canceled' => 'cancel',
        ];

        $iconMap = [
            'pending' => 'fas fa-clock',
            'processing' => 'fas fa-utensils',
            'completed' => 'fas fa-check-circle',
            'canceled' => 'fas fa-times-circle',
        ];

        return [
            'status' => $status,
            'statusLabel' => $labelMap[$status] ?? ucfirst($status),
            'statusClass' => $classMap[$status] ?? 'wait',
            'statusIcon' => $iconMap[$status] ?? 'fas fa-info-circle',
        ];
    }

    private function paymentPayload(string $paymentStatus): array
    {
        $labelMap = [
            'unpaid' => 'Belum Dibayar',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Gagal / Kadaluarsa',
        ];

        $classMap = [
            'unpaid' => 'wait',
            'paid' => 'done',
            'failed' => 'cancel',
        ];

        $iconMap = [
            'unpaid' => 'fas fa-credit-card',
            'paid' => 'fas fa-wallet',
            'failed' => 'fas fa-exclamation-triangle',
        ];

        return [
            'paymentStatus' => $paymentStatus,
            'paymentLabel' => $labelMap[$paymentStatus] ?? ucfirst($paymentStatus),
            'paymentClass' => $classMap[$paymentStatus] ?? 'wait',
            'paymentIcon' => $iconMap[$paymentStatus] ?? 'fas fa-wallet',
        ];
    }

    public function index()
    {
        $orderModel = model(OrderModel::class);
        $orderModel->autoPromoteWaitingOrders();

        $payment = $this->request->getGet('payment');

        $builder = $orderModel
            ->select('orders.*, users.name as customer_name, roles.name as customer_role')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->join('roles', 'roles.id = users.role_id', 'left');

        if ($payment === 'lunas') {
            $builder->where('orders.payment_status', 'paid');
        } elseif ($payment === 'belum') {
            $builder->where('orders.payment_status !=', 'paid');
        }

        $orders = $builder
            ->orderBy('orders.created_at', 'DESC')
            ->paginate(10);

        $pager = $orderModel->pager;

        return view('admin/orders/index', [
            'orders'  => $orders,
            'pager'   => $pager,
            'payment' => $payment,
        ]);
    }

    public function statuses()
    {
        $ids = array_filter(array_map('intval', explode(',', (string) $this->request->getGet('ids'))));

        if (empty($ids)) {
            return $this->response->setJSON([
                'ok' => true,
                'orders' => [],
            ]);
        }

        $rows = model(OrderModel::class)
            ->select('id, status, payment_status')
            ->whereIn('id', $ids)
            ->findAll();

        $orders = [];
        foreach ($rows as $row) {
            $status = (string) ($row['status'] ?? 'pending');
            $paymentStatus = (string) ($row['payment_status'] ?? 'unpaid');
            $orders[] = [
                'orderId' => (int) $row['id'],
            ] + $this->statusPayload($status) + $this->paymentPayload($paymentStatus);
        }

        return $this->response->setJSON([
            'ok' => true,
            'orders' => $orders,
        ]);
    }

    public function create()
    {
        $menus = model(MenuModel::class)
            ->where('is_active', 1)
            ->where('stock >', 0)
            ->orderBy('name', 'ASC')
            ->findAll();

        return view('admin/orders/create', [
            'menus' => $menus,
        ]);
    }

    public function store()
    {
        $admin = session('user');
        $userId = (int) ($admin['id'] ?? 0);
        $paymentStatus = 'paid';
        $notes = trim((string) $this->request->getPost('notes'));
        $menuIds = (array) $this->request->getPost('menu_id');
        $qtys = (array) $this->request->getPost('qty');

        if ($userId <= 0) {
            if ($this->isAjaxRequest()) {
                return $this->response->setStatusCode(401)->setJSON($this->withCsrf([
                    'ok' => false,
                    'message' => 'Session admin tidak ditemukan.',
                ]));
            }
            return redirect()->back()->withInput()->with('error', 'Session admin tidak ditemukan.');
        }

        $menuModel = model(MenuModel::class);
        $items = [];
        $total = 0;

        foreach ($menuIds as $index => $menuId) {
            $menuId = (int) $menuId;
            $qty = max(0, (int) ($qtys[$index] ?? 0));

            if ($menuId <= 0 || $qty <= 0) {
                continue;
            }

            $menu = $menuModel->find($menuId);
            if (!$menu || (int) ($menu['is_active'] ?? 0) !== 1) {
                if ($this->isAjaxRequest()) {
                    return $this->response->setStatusCode(422)->setJSON($this->withCsrf([
                        'ok' => false,
                        'message' => 'Ada menu yang tidak tersedia.',
                    ]));
                }
                return redirect()->back()->withInput()->with('error', 'Ada menu yang tidak tersedia.');
            }

            if ((int) ($menu['stock'] ?? 0) < $qty) {
                if ($this->isAjaxRequest()) {
                    return $this->response->setStatusCode(422)->setJSON($this->withCsrf([
                        'ok' => false,
                        'message' => "Stok {$menu['name']} tidak mencukupi.",
                    ]));
                }
                return redirect()->back()->withInput()->with('error', "Stok {$menu['name']} tidak mencukupi.");
            }

            $price = (int) $menu['price'];
            $subtotal = $price * $qty;
            $total += $subtotal;
            $items[] = [
                'menu_id' => $menuId,
                'name' => $menu['name'],
                'price' => $price,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        if (empty($items)) {
            if ($this->isAjaxRequest()) {
                return $this->response->setStatusCode(422)->setJSON($this->withCsrf([
                    'ok' => false,
                    'message' => 'Pilih minimal satu menu.',
                ]));
            }
            return redirect()->back()->withInput()->with('error', 'Pilih minimal satu menu.');
        }

        $db = db_connect();
        $orderModel = model(OrderModel::class);
        $itemModel = model(OrderItemModel::class);

        $db->transBegin();

        try {
            $orderData = [
                'user_id' => $userId,
                'code' => $this->generateOrderCode($orderModel),
                'total_amount' => $total,
                'status' => 'processing',
                'delivery_method' => 'pickup',
                'delivery_address_id' => null,
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentStatus === 'paid' ? 'cash' : null,
                'payment_type' => $paymentStatus === 'paid' ? 'cash' : null,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if ($notes !== '' && $db->fieldExists('notes', 'orders')) {
                $orderData['notes'] = $notes;
            }

            $orderId = $orderModel->insert($orderData);

            foreach ($items as $item) {
                $item['order_id'] = $orderId;
                $itemModel->insert($item);

                $db->table('menus')
                    ->set('stock', 'stock - ' . (int) $item['qty'], false)
                    ->where('id', (int) $item['menu_id'])
                    ->where('stock >=', (int) $item['qty'])
                    ->update();

                if ($db->affectedRows() === 0) {
                    throw new \RuntimeException("Stok {$item['name']} berubah, pesanan gagal dibuat.");
                }
            }

            $db->transCommit();

            if ($this->isAjaxRequest()) {
                return $this->response->setJSON($this->withCsrf([
                    'ok' => true,
                    'message' => 'Pesanan kantin berhasil dibuat oleh admin.',
                    'orderId' => (int) $orderId,
                    'redirect' => base_url('admin/orders/' . $orderId),
                ]));
            }

            return redirect()->to(base_url('admin/orders/' . $orderId))
                ->with('success', 'Pesanan kantin berhasil dibuat oleh admin.');
        } catch (\Throwable $e) {
            $db->transRollback();
            if ($this->isAjaxRequest()) {
                return $this->response->setStatusCode(500)->setJSON($this->withCsrf([
                    'ok' => false,
                    'message' => $e->getMessage(),
                ]));
            }
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    private function generateOrderCode(OrderModel $orderModel): string
    {
        do {
            $code = 'ORD' . date('ymdHis') . random_int(10, 99);
        } while ($orderModel->where('code', $code)->first());

        return $code;
    }


    public function show($id)
    {
        $id         = (int) $id;
        $orderModel = model(OrderModel::class);
        $itemModel  = model(OrderItemModel::class);

        $orderModel->autoPromoteWaitingOrders();
        $order = $orderModel
            ->select(
                'orders.*,
             users.name AS customer_name,
             users.no_hp AS no_hp,
             roles.name AS customer_role,
             ua.building AS address_building,
             ua.room     AS address_room,
             ua.note     AS address_note'
            )
            ->join('users', 'users.id = orders.user_id', 'left')
            ->join('roles', 'roles.id = users.role_id', 'left')
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
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Status tidak dikenal.',
            ], (string) previous_url(), 'error', 422);
        }

        $orderModel = model(OrderModel::class);
        $order      = $orderModel->find($id);

        if (!$order) {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], base_url('admin/orders'), 'error', 404);
        }

        $orderModel->update($id, ['status' => $status]);

        return $this->jsonOrRedirect([
            'ok' => true,
            'message' => 'Status pesanan diperbarui.',
            'orderId' => $id,
        ] + $this->statusPayload($status), (string) previous_url());
    }
    public function markPaid($id)
    {
        $id = (int) $id;

        $orderModel = model(OrderModel::class);
        $order      = $orderModel->find($id);

        if (! $order) {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], base_url('admin/orders'), 'error', 404);
        }

        if ($order['status'] === 'canceled') {
            return $this->jsonOrRedirect([
                'ok' => false,
                'message' => 'Pesanan yang dibatalkan tidak bisa ditandai sudah dibayar.',
            ], (string) previous_url(), 'error', 422);
        }

        $orderModel->update($id, [
            'payment_status' => 'paid',
            // kalau di tabel ada kolom ini, boleh diisi juga:
            // 'payment_method' => 'cash',
            // 'paid_at'        => date('Y-m-d H:i:s'),
        ]);

        return $this->jsonOrRedirect([
            'ok' => true,
            'message' => 'Pembayaran ditandai sudah dibayar (tunai).',
            'orderId' => $id,
        ] + $this->paymentPayload('paid'), (string) previous_url());
    }
    public function nota($id)
    {
        $id = (int)$id;
        $orderModel = model(\App\Models\OrderModel::class);

        $order = $orderModel
            ->select('orders.*, users.name AS customer_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $items = model(\App\Models\OrderItemModel::class)->where('order_id', $id)->findAll();

        $order['items'] = $items;

        return view('orders/nota', [
            'order' => $order,
            'user'  => ['name' => $order['customer_name']],
        ]);
    }

    public function notaPdf($id)
    {
        $id = (int)$id;
        $orderModel = model(\App\Models\OrderModel::class);

        $order = $orderModel
            ->select('orders.*, users.name AS customer_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $items = model(\App\Models\OrderItemModel::class)->where('order_id', $id)->findAll();
        $order['items'] = $items;

        $html = view('orders/nota_pdf', ['order' => $order, 'user' => ['name' => $order['customer_name']]]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 210, 600]);
        $dompdf->render();
        $output = $dompdf->output();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', "inline; filename=nota_{$order['code']}.pdf")
            ->setBody($output);
    }
}
