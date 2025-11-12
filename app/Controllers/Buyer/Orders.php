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
}
