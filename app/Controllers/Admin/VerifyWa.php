<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class VerifyWa extends BaseController
{
    public function index()
    {
        $users = (new UserModel())
            ->where('wa_verified', 0)
            ->where('role_id IS NOT NULL')
            ->findAll();

        return view('admin/verify_wa', [
            'users' => $users
        ]);
    }

    public function verify($id)
    {
        (new UserModel())->update($id, [
            'wa_verified'    => 1,
            'wa_verified_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()
            ->with('success', 'User berhasil diverifikasi.');
    }
}
