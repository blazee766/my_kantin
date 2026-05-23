<?php

namespace App\Controllers;

use App\Models\MenuModel;

class Home extends BaseController
{
    public function index()
    {
        $menus = (new \App\Models\MenuModel())
            ->where('is_active', 1)
            ->where('is_popular', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        $addresses = [];
        $user = session('user');

        if ($user) {
            $addresses = (new \App\Models\UserAddressModel())
                ->orderBy('is_default', 'DESC')
                ->orderBy('id', 'ASC')
                ->findAll();   
        }

        return view('home/index_full', [
            'menus'     => $menus,
            'addresses' => $addresses,
        ]);
    }


    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function menu()
    {
        $catSlug     = $this->request->getGet('cat');
        $categories  = model(\App\Models\CategoryModel::class)
            ->orderBy('name', 'ASC')
            ->findAll();

        $addresses = [];
        $user = session('user');

        if ($user) {
            $addresses = (new \App\Models\UserAddressModel())
                ->orderBy('is_default', 'DESC')
                ->orderBy('id', 'ASC')
                ->findAll();   
        }

        return view('home/menu', [
            'categories' => $categories,
            'activeSlug' => $catSlug,
            'addresses'  => $addresses,
        ]);
    }

    public function menuJson()
    {
        $catSlug   = $this->request->getGet('cat');
        $catModel  = model(\App\Models\CategoryModel::class);
        $menuModel = model(\App\Models\MenuModel::class);

        $categories = $catModel->orderBy('name', 'ASC')->findAll();
        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat['id']] = [
                'name' => $cat['name'],
                'slug' => $cat['slug'] ?? '',
            ];
        }

        $menuModel->where('is_active', 1)->orderBy('name', 'ASC');

        if ($catSlug) {
            $cat = $catModel->where('slug', $catSlug)->first();
            if ($cat) $menuModel->where('category_id', (int)$cat['id']);
        }

        $menus = $menuModel->findAll();

        $soldRows = db_connect()
            ->table('order_items oi')
            ->select('oi.menu_id, COALESCE(SUM(oi.qty), 0) AS sold', false)
            ->join('orders o', 'o.id = oi.order_id', 'left')
            ->whereNotIn('o.status', ['canceled', 'batal'])
            ->groupBy('oi.menu_id')
            ->get()
            ->getResultArray();

        $soldMap = [];
        foreach ($soldRows as $row) {
            $soldMap[(int)$row['menu_id']] = (int)$row['sold'];
        }

        $out = array_map(function ($m) use ($categoryMap, $soldMap) {
            $stock = (int)($m['stock'] ?? 0);
            $menuId = (int)$m['id'];
            $sold = $soldMap[$menuId] ?? 0;

            return [
                'id'            => $menuId,
                'name'          => $m['name'],
                'description'   => (string)($m['description'] ?? ''),
                'price'         => (int)$m['price'],
                'stock'         => $stock,
                'stock_label'   => $stock > 0 ? sprintf('%d tersisa', $stock) : 'Habis',
                'stock_status'  => $stock > 0 ? ($stock <= 5 ? 'low' : 'available') : 'out',
                'image'         => (string)($m['image'] ?? ''),
                'is_popular'    => (bool)($m['is_popular'] ?? false),
                'category_name' => $categoryMap[$m['category_id']]['name'] ?? '',
                'category_slug' => $categoryMap[$m['category_id']]['slug'] ?? '',
                'sold'          => $sold,
                'rating'        => isset($m['rating']) ? (float)$m['rating'] : 4.8,
            ];
        }, $menus);

        return $this->response->setJSON([
            'data'       => $out,
            'categories' => array_map(function ($cat) {
                return [
                    'id'   => (int)$cat['id'],
                    'slug' => $cat['slug'] ?? '',
                    'name' => $cat['name'],
                ];
            }, $categories),
        ]);
    }
}
