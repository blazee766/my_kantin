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
        return view('home/index_full', ['menus' => $menus]);
    }
    public function menu()
    {
        // hanya kirim daftar kategori + slug & slug aktif 
        $catSlug     = $this->request->getGet('cat');
        $categories  = model(\App\Models\CategoryModel::class)->orderBy('name', 'ASC')->findAll();

        return view('home/menu', [
            'categories' => $categories,
            'activeSlug' => $catSlug
        ]);
    }

    public function menuJson()
    {
        $catSlug   = $this->request->getGet('cat'); 
        $catModel  = model(\App\Models\CategoryModel::class);
        $menuModel = model(\App\Models\MenuModel::class);

        $menuModel->where('is_active', 1)->orderBy('name', 'ASC');

        if ($catSlug) {
            $cat = $catModel->where('slug', $catSlug)->first();
            if ($cat) $menuModel->where('category_id', (int)$cat['id']);
        }

        $menus = $menuModel->findAll();

        // kirim data yang perlu saja
        $out = array_map(function ($m) {
            return [
                'id'    => (int)$m['id'],
                'name'  => $m['name'],
                'description' => (string)($m['description'] ?? ''),
                'price' => (int)$m['price'],
                'stock' => (int)($m['stock'] ?? 0),
                'image' => (string)($m['image'] ?? ''),
            ];
        }, $menus);

        return $this->response->setJSON(['data' => $out]);
    }
}
