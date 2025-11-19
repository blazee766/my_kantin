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

    // tampilkan isi keranjang sederhana
    public function index()
    {
        $u = $this->userOrRedirect();
        if ($u instanceof \CodeIgniter\HTTP\RedirectResponse) return $u;

        $cart = session('cart') ?? [];
        return view('cart/index', ['cart' => $cart]);
    }

    // tambah item ke keranjang (session)
    public function add()
    {
        $u = session('user');
        if (!$u) {
            return $this->response->setStatusCode(401)->setJSON(['ok' => false, 'msg' => 'Anda harus login terlebih dahulu untuk memesan. Buka halaman login sekarang?']);
        }

        // ---- BLOCK ADMIN: admin tidak boleh membuat pesanan ----
        if (isset($u['role']) && $u['role'] === 'admin') {
            return $this->response->setStatusCode(403)->setJSON(['ok' => false, 'msg' => 'Akun admin tidak diperbolehkan memesan.']);
        }
        // --------------------------------------------------------

        $id  = (int) $this->request->getPost('id');
        $qty = max(1, (int) $this->request->getPost('qty'));

        $menu = model(\App\Models\MenuModel::class)->find($id);
        if (!$menu || !(int)$menu['is_active']) {
            return $this->response->setJSON(['ok' => false, 'msg' => 'Menu tidak tersedia']);
        }

        if ($menu['stock'] < $qty) {
            return $this->response->setJSON(['ok' => false, 'msg' => 'Stok tidak mencukupi']);
        }

        $db = db_connect();
        $db->transBegin();

        try {
            $orderModel = model(\App\Models\OrderModel::class);
            $itemModel  = model(\App\Models\OrderItemModel::class);

            // Hitung total
            $total = $menu['price'] * $qty;

            // Buat order baru
            $orderCode = 'ORD' . date('ymdHis');
            $orderId = $orderModel->insert([
                'user_id'      => $u['id'],
                'code'         => $orderCode,
                'total_amount' => $total,
                'status'       => 'menunggu',
                'created_at'   => date('Y-m-d H:i:s'),
            ]);

            // Simpan item pesanan
            $itemModel->insert([
                'order_id' => $orderId,
                'menu_id'  => $menu['id'],
                'name'     => $menu['name'],
                'price'    => $menu['price'],
                'qty'      => $qty,
                'subtotal' => $total,
            ]);

            // Kurangi stok
            $db->query("UPDATE menus SET stock = stock - ? WHERE id = ? AND stock >= ?", [$qty, $menu['id'], $qty]);
            if ($db->affectedRows() === 0) {
                throw new \RuntimeException('Stok berubah, gagal menyimpan pesanan.');
            }

            $db->transCommit();

            return $this->response->setJSON([
                'ok' => true,
                'msg' => 'Pesanan berhasil dibuat.',
                'redirect' => site_url('p/orders')
            ]);
        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->response->setJSON(['ok' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function updateQty()
    {
        // optional: require login to update cart (keputusan produk)
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

    // ←— BAGIAN PENTING —→  Membuat pesanan dari isi keranjang
    public function checkout()
    {
        $u = $this->userOrRedirect();
        if ($u instanceof \CodeIgniter\HTTP\RedirectResponse) return $u;

        // ---- BLOCK ADMIN: admin tidak boleh checkout ----
        if (isset($u['role']) && $u['role'] === 'admin') {
            return redirect()->to(site_url('cart'))->with('error', 'Admin tidak boleh membuat pesanan.');
        }
        // --------------------------------------------------

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

            // hitung total & cek stok
            $total = 0;
            foreach ($cart as $row) {
                // lock row stok (optimis)
                $menu = $menuModel->where('id', $row['id'])->first();
                if (!$menu) throw new \RuntimeException('Menu tidak ditemukan.');
                if ((int)$menu['stock'] < (int)$row['qty']) {
                    throw new \RuntimeException("Stok {$menu['name']} tidak mencukupi.");
                }
                $total += ((int)$row['price'] * (int)$row['qty']);
            }

            // buat order
            $code = 'ORD' . date('ymdHis');
            $orderId = $orderModel->insert([
                'user_id'      => (int)$u['id'],
                'code'         => $code,
                'total_amount' => $total,
                'status'       => 'menunggu', // atau 'dibuat'
                'created_at'   => date('Y-m-d H:i:s'),
            ]);

            // insert items & kurangi stok
            foreach ($cart as $row) {
                $itemModel->insert([
                    'order_id' => $orderId,
                    'menu_id'  => $row['id'],
                    'name'     => $row['name'],
                    'price'    => (int)$row['price'],
                    'qty'      => (int)$row['qty'],
                    'subtotal' => (int)$row['price'] * (int)$row['qty'],
                ]);

                // kurangi stok
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
            return redirect()->to(site_url('p/orders'))
                ->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to(site_url('cart'))
                ->with('error', $e->getMessage());
        }
    }
}
