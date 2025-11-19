<?php
namespace App\Controllers\Buyer;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Orders extends BaseController
{
    private function mustLogin()
    {
        $user = session('user');
        if (!$user) {
            return redirect()->to(site_url('login'))
                ->with('error','Silakan login terlebih dahulu.');
        }
        return $user;
    }

    public function index()
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse) return $check;
        $user = $check;

        $orders = (new OrderModel())->getByUser((int)$user['id']);

        return view('orders/index', [
            'orders' => $orders,
            'user'   => $user,
        ]);
    }

    public function show($id)
    {
        $check = $this->mustLogin();
        if ($check instanceof \CodeIgniter\HTTP\RedirectResponse) return $check;
        $user = $check;

        $order = (new OrderModel())->getOneWithItems((int)$id, (int)$user['id']);
        if (!$order) {
            return redirect()->to(site_url('orders'))->with('error','Pesanan tidak ditemukan.');
        }

        return view('orders/show', [
            'order' => $order,
            'user'  => $user,
        ]);
    }
    public function delete(int $id)
{
    $check = $this->mustLogin();
    if ($check instanceof \CodeIgniter\HTTP\RedirectResponse) return $check;
    $user = $check;

    $orderModel = new \App\Models\OrderModel();

    // ambil order + items
    $order = $orderModel->getOneWithItems($id, (int)$user['id']);
    if (!$order) {
        return redirect()->to(site_url('p/orders'))->with('error','Pesanan tidak ditemukan.');
    }

    // jika sudah dibayar → tolak hapus
    if (($order['status'] ?? '') === 'paid') {
        return redirect()->to(site_url('p/orders/'.$id))->with('error','Pesanan sudah dibayar dan tidak bisa dihapus.');
    }

    $db = \Config\Database::connect();
    $db->transStart();

    // 1) restock
    foreach ($order['items'] ?? [] as $item) {
        $menuId = (int) ($item['menu_id'] ?? 0);
        $qty    = (int) ($item['qty'] ?? 0);
        if ($menuId > 0 && $qty > 0) {
            $db->table('menus')->set('stock', "stock + {$qty}", false)->where('id', $menuId)->update();
        }
    }

    // 2) hapus order_items
    $db->table('order_items')->where('order_id', $id)->delete();

    // 3) hapus payments
    $db->table('payments')->where('order_id', $id)->delete();

    // 4) hapus orders
    $db->table('orders')->where('id', $id)->delete();

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->to(site_url('p/orders/'.$id))->with('error','Gagal menghapus pesanan (transaksi gagal).');
    }

    return redirect()->to(site_url('p/orders'))->with('success','Pesanan berhasil dihapus.');
}

    
}

