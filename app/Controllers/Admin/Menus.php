<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class Menus extends BaseController
{
    public function index()
    {
        $menuModel = new MenuModel();

        $jenis = $this->request->getGet('jenis');

        $builder = $menuModel
            ->select('menus.*, categories.name AS category_name')
            ->join('categories', 'categories.id = menus.category_id', 'left');

        if ($jenis === 'makanan') {
            $builder->where('categories.name', 'Makanan');
        } elseif ($jenis === 'minuman') {
            $builder->where('categories.name', 'Minuman');
        }

        $menus = $builder
            ->orderBy('menus.id', 'DESC')
            ->paginate(10);

        $pager = $menuModel->pager;

        return view('admin/menus/index', compact('menus', 'pager', 'jenis'));
    }

    public function create()
    {
        $cats = model(\App\Models\CategoryModel::class)->orderBy('name', 'ASC')->findAll();
        return view('admin/menus/form', ['menu' => null, 'mode' => 'create', 'cats' => $cats]);
    }

    public function store()
    {
        $m = new MenuModel();

        $data = [
            'name' => trim($this->request->getPost('name')),
            'slug' => url_title(trim($this->request->getPost('name')), '-', true),
            'description' => $this->request->getPost('description'),
            'price' => (int)$this->request->getPost('price'),
            'stock' => max(0, (int)$this->request->getPost('stock')),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'is_popular' => $this->request->getPost('is_popular') ? 1 : 0,
            'category_id' => (int)$this->request->getPost('category_id') ?: null,
        ];
        
        if (!$m->save($data)) {
            return redirect()->back()->with('error', implode(' ', $m->errors()))->withInput();
        }
        $id = $m->getInsertID();

        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $newName = $id . '-' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'assets/img', $newName, true);
            $m->update($id, ['image' => $newName]);
        }
        return redirect()->to('/admin/menus')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $menu = (new \App\Models\MenuModel())->find($id);
        $cats = model(\App\Models\CategoryModel::class)->orderBy('name', 'ASC')->findAll();
        return view('admin/menus/form', ['menu' => $menu, 'mode' => 'edit', 'cats' => $cats]);
    }

    public function update($id)
    {
        $m = new MenuModel();
        $id = (int)$id;

        $data = [
            'id' => $id,
            'name' => trim($this->request->getPost('name')),
            'slug' => url_title(trim($this->request->getPost('name')), '-', true),
            'description' => $this->request->getPost('description'),
            'price' => (int)$this->request->getPost('price'),
            'stock' => max(0, (int)$this->request->getPost('stock')),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'is_popular' => $this->request->getPost('is_popular') ? 1 : 0,
            'category_id' => (int)$this->request->getPost('category_id') ?: null,

        ];
        if (!$m->save($data)) {
            return redirect()->back()->with('error', implode(' ', $m->errors()))->withInput();
        }

        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $newName = $id . '-' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'assets/img', $newName, true);
            $m->update($id, ['image' => $newName]);
        }
        return redirect()->to('/admin/menus')->with('success', 'Menu diperbarui.');
    }

    public function delete($id)
    {
        $id = (int) $id;
        $db = \Config\Database::connect();

        $used = $db->table('order_items')->where('menu_id', $id)->countAllResults();

        if ($used > 0) {
            return redirect()->to('/admin/menus')
                ->with('error', 'Menu ini sudah pernah dipesan sehingga tidak dapat dihapus. Silakan nonaktifkan menu saja.');
        }

        (new MenuModel())->delete($id);
        return redirect()->to('/admin/menus')->with('success', 'Menu dihapus.');
    }

    public function search()
    {
        $q = trim((string) $this->request->getGet('q'));

        $limitParam = (int) $this->request->getGet('limit');
        $limit = ($limitParam >= 5 && $limitParam <= 100) ? $limitParam : null;

        $model = new MenuModel();

        $builder = $model->select(['id', 'name', 'description', 'price', 'image'])
            ->where('is_active', 1);

        if ($q === '') {
            $builder->orderBy('id', 'DESC');
            $menus = $builder->findAll($limit ?? 20);
        } else {
            $builder->groupStart()
                ->like('name', $q)
                ->orLike('description', $q)
                ->groupEnd()
                ->orderBy('name', 'ASC');

            $menus = $builder->findAll($limit ?? 40);
        }

        return $this->response->setJSON([
            'ok'    => true,
            'q'     => $q,
            'count' => count($menus),
            'items' => array_map(function ($m) {
                return [
                    'id'    => (int) $m['id'],
                    'name'  => (string) $m['name'],
                    'desc'  => (string) ($m['description'] ?? ''),
                    'price' => (float) $m['price'],
                    'image' => (string) ($m['image'] ?? ''),
                ];
            }, $menus),
        ]);
    }
}
