<?php

namespace App\Controllers\Buyer;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Cart extends BaseController
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

    public function index()
    {
        $u = $this->userOrRedirect();
        if ($u instanceof \CodeIgniter\HTTP\RedirectResponse) return $u;

        $cart = session('cart') ?? [];
        return view('cart/index', ['cart' => $cart]);
    }

    public function add()
    {
        $id  = (int) $this->request->getPost('id');
        $qty = (int) $this->request->getPost('qty');
        $deliveryMethod = $this->request->getPost('delivery_method');
        if (! in_array($deliveryMethod, ['pickup', 'delivery'], true)) {
            $deliveryMethod = 'pickup';
        }
        session()->set('delivery_method', $deliveryMethod);

        $deliveryAddressId = (int) $this->request->getPost('delivery_address_id');
        if ($deliveryMethod === 'delivery' && $deliveryAddressId > 0) {
            session()->set('delivery_address_id', $deliveryAddressId);
        }

        $u = session('user');
        if (!$u) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'ok'  => false,
                    'msg' => 'Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?',
                ]);
        }
        /*
        if (isset($u['role']) && $u['role'] === 'admin') {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'ok'  => false,
                    'msg' => 'Akun admin tidak diperbolehkan memesan.',
                ]);
        }
        */
        $u = session('user');
        $userRow = db_connect()
            ->table('users')
            ->select('wa_verified')
            ->where('id', $u['id'])
            ->get()
            ->getRowArray();

        if ((int)($userRow['wa_verified'] ?? 0) !== 1) {
            return $this->response->setJSON([
                'ok'  => false,
                'msg' => 'Nomor WhatsApp belum diverifikasi. Silakan verifikasi terlebih dahulu.',
                'redirect' => site_url('verify-wa')
            ]);
        }

        $id  = (int) $this->request->getPost('id');
        $qty = max(1, (int) $this->request->getPost('qty'));

        $menu = model(\App\Models\MenuModel::class)->find($id);
        if (!$menu || !(int) $menu['is_active']) {
            return $this->response->setJSON(['ok' => false, 'msg' => 'Menu tidak tersedia']);
        }

        if ($menu['stock'] < $qty) {
            return $this->response->setJSON(['ok' => false, 'msg' => 'Stok tidak mencukupi']);
        }

        $db         = db_connect();
        $orderModel = model(\App\Models\OrderModel::class);
        $itemModel  = model(\App\Models\OrderItemModel::class);

        $db->transBegin();

        try {
            $total = (int) $menu['price'] * $qty;
            $existingOrder = $orderModel->getPendingByUser((int) $u['id'], $deliveryMethod);

            if ($existingOrder) {
                $orderId = (int) $existingOrder['id'];

                $updateData = [
                    'total_amount'    => (int) $existingOrder['total_amount'] + $total,
                    'delivery_method' => $deliveryMethod,
                ];

                if ($deliveryMethod === 'delivery' && $deliveryAddressId > 0) {
                    $updateData['delivery_address_id'] = $deliveryAddressId;
                }

                $orderModel->update($orderId, $updateData);
            } else {
                $orderCode = 'ORD' . date('ymdHis');

                $insertData = [
                    'user_id'         => (int) $u['id'],
                    'code'            => $orderCode,
                    'total_amount'    => $total,
                    'status'          => 'pending',
                    'delivery_method' => $deliveryMethod,
                    'created_at'      => date('Y-m-d H:i:s'),
                ];

                if ($deliveryMethod === 'delivery' && $deliveryAddressId > 0) {
                    $insertData['delivery_address_id'] = $deliveryAddressId;
                }

                $orderId   = $orderModel->insert($insertData);
            }

            $itemModel->insert([
                'order_id' => $orderId,
                'menu_id'  => $menu['id'],
                'name'     => $menu['name'],
                'price'    => (int) $menu['price'],
                'qty'      => $qty,
                'subtotal' => $total,
            ]);

            $db->query(
                "UPDATE menus SET stock = stock - ? WHERE id = ? AND stock >= ?",
                [$qty, $menu['id'], $qty]
            );
            if ($db->affectedRows() === 0) {
                throw new \RuntimeException('Stok berubah, gagal menyimpan pesanan.');
            }

            if ($existingOrder) {
                $orderId = (int) $existingOrder['id'];

                $updateData = [
                    'total_amount'    => (int) $existingOrder['total_amount'] + $total,
                    'delivery_method' => $deliveryMethod,
                ];

                if ($deliveryMethod === 'delivery' && $deliveryAddressId > 0) {
                    $updateData['delivery_address_id'] = $deliveryAddressId;
                }

                $orderModel->update($orderId, $updateData);
            } else {
                $orderCode = 'ORD' . date('ymdHis');

                $insertData = [
                    'user_id'         => (int) $u['id'],
                    'code'            => $orderCode,
                    'total_amount'    => $total,
                    'status'          => 'pending',
                    'delivery_method' => $deliveryMethod,
                    'created_at'      => date('Y-m-d H:i:s'),
                ];

                if ($deliveryMethod === 'delivery' && $deliveryAddressId > 0) {
                    $insertData['delivery_address_id'] = $deliveryAddressId;
                }

                $orderId   = $orderModel->insert($insertData);
            }

            if ($deliveryMethod === 'delivery' && $deliveryAddressId > 0) {
                $addr = $db->table('user_addresses')
                    ->where('id', $deliveryAddressId)
                    ->get()
                    ->getRowArray();

                if ($addr) {
                    $label = $addr['building'] ?? '';
                    if (!empty($addr['room'])) {
                        $label .= ' - ' . $addr['room'];
                    }
                    if (!empty($addr['note'])) {
                        $label .= ' (' . $addr['note'] . ')';
                    }
                    session()->set('delivery_display', $label);
                }
            }

            $db->transCommit();

            return $this->response->setJSON([
                'ok'       => true,
                'msg'      => 'Pesanan berhasil dibuat / ditambahkan.',
                'redirect' => site_url('p/orders'),
            ]);
        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'ok'  => false,
                'msg' => 'Gagal menambahkan item: ' . $e->getMessage(),
            ]);
        }
    }

    public function updateQty()
    {
        $u = session('user');
        if (!$u) {
            return $this->response->setStatusCode(401)->setJSON(['ok' => false, 'msg' => 'Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?']);
        }

        $id  = (int)$this->request->getPost('id');
        $qty = max(1, (int)$this->request->getPost('qty'));
        $cart = session('cart') ?? [];
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            session()->set('cart', $cart);
        }
        return $this->response->setJSON(['ok' => true]);
    }

    public function remove()
    {
        $u = session('user');
        if (!$u) {
            return $this->response->setStatusCode(401)->setJSON(['ok' => false, 'msg' => 'Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?']);
        }

        $id = (int)$this->request->getPost('id');
        $cart = session('cart') ?? [];
        unset($cart[$id]);
        session()->set('cart', $cart);
        return $this->response->setJSON(['ok' => true]);
    }

    public function clear()
    {
        $u = session('user');
        if (!$u) {
            return $this->response->setStatusCode(401)->setJSON(['ok' => false, 'msg' => 'Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?']);
        }

        session()->remove('cart');
        return $this->response->setJSON(['ok' => true]);
    }

    public function count()
    {
        $cart = session('cart') ?? [];
        $count = array_sum(array_column($cart, 'qty'));
        return $this->response->setJSON(['count' => $count]);
    }

    public function checkout()
    {
        $u = $this->userOrRedirect();
        if ($u instanceof \CodeIgniter\HTTP\RedirectResponse) return $u;

        $userRow = db_connect()
            ->table('users')
            ->select('wa_verified')
            ->where('id', $u['id'])
            ->get()
            ->getRowArray();

        if ((int)($userRow['wa_verified'] ?? 0) !== 1) {
            return redirect()->to('/verify-wa')
                ->with('error', 'Silakan verifikasi nomor WhatsApp sebelum melakukan checkout.');
        }

        $cart = session('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to(site_url('cart'))->with('error', 'Keranjang masih kosong.');
        }

        $db = db_connect();
        $db->transBegin();

        try {
            $menuModel  = model(MenuModel::class);
            $orderModel = model(OrderModel::class);
            $itemModel  = model(OrderItemModel::class);

            $total = 0;
            foreach ($cart as $row) {
                $menu = $menuModel->where('id', $row['id'])->first();
                if (!$menu) throw new \RuntimeException('Menu tidak ditemukan.');
                if ((int)$menu['stock'] < (int)$row['qty']) {
                    throw new \RuntimeException("Stok {$menu['name']} tidak mencukupi.");
                }
                $total += ((int)$row['price'] * (int)$row['qty']);
            }

            $code = 'ORD' . date('ymdHis');
            $orderId = $orderModel->insert([
                'user_id'      => (int)$u['id'],
                'code'         => $code,
                'total_amount' => $total,
                'status'       => 'pending',
                'created_at'   => date('Y-m-d H:i:s'),
            ]);

            foreach ($cart as $row) {
                $itemModel->insert([
                    'order_id' => $orderId,
                    'menu_id'  => $row['id'],
                    'name'     => $row['name'],
                    'price'    => (int)$row['price'],
                    'qty'      => (int)$row['qty'],
                    'subtotal' => (int)$row['price'] * (int)$row['qty'],
                ]);

                $db->query(
                    "UPDATE menus SET stock = stock - ? WHERE id = ? AND stock >= ?",
                    [(int)$row['qty'], (int)$row['id'], (int)$row['qty']]
                );
                if ($db->affectedRows() === 0) {
                    throw new \RuntimeException("Stok berubah, gagal mengurangi untuk {$row['name']}.");
                }
            }

            $db->transCommit();
            session()->remove('cart');
            return redirect()->to(site_url('/'))
                ->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to(site_url('cart'))
                ->with('error', $e->getMessage());
        }
    }
}
