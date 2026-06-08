<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\MenuModel;
use Dompdf\Dompdf;

class Orders extends BaseController
{
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
                return redirect()->back()->withInput()->with('error', 'Ada menu yang tidak tersedia.');
            }

            if ((int) ($menu['stock'] ?? 0) < $qty) {
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

            return redirect()->to(base_url('admin/orders/' . $orderId))
                ->with('success', 'Pesanan kantin berhasil dibuat oleh admin.');
        } catch (\Throwable $e) {
            $db->transRollback();
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
