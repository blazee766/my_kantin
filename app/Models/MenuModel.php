<?php
namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table         = 'menus';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'category_id','name','slug','description',
        'price','stock','image','is_active','is_popular'
    ];
    protected $returnType    = 'array';

    // timestamps (aktifkan jika tabel punya kolom ini)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'  => 'required|min_length[3]',
        'price' => 'required|decimal',         // konsisten dengan kemungkinan harga desimal
        'stock' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'name'  => [
            'required'   => 'Nama menu wajib diisi.',
            'min_length' => 'Nama menu minimal 3 karakter.'
        ],
        'price' => [
            'required' => 'Harga wajib diisi.',
            'decimal'  => 'Harga harus berupa angka (boleh desimal).'
        ],
        'stock' => [
            'integer' => 'Stok harus berupa angka.'
        ]
    ];

    // helper scopes
    public function scopeActive()
    {
        return $this->where('is_active', 1);
    }

    public function getActiveMenus(int $limit = 20)
    {
        return $this->scopeActive()->orderBy('id', 'DESC')->findAll($limit);
    }

    public function getPopularMenus(int $limit = 20)
    {
        return $this->scopeActive()->where('is_popular', 1)->orderBy('id', 'DESC')->findAll($limit);
    }
}
