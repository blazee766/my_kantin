<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    /* =========================
     * LOGIN
     * ========================= */
    public function attempt()
    {
        $no_hp    = trim((string) $this->request->getPost('no_hp'));
        $password = (string) $this->request->getPost('password');

        if ($no_hp === '' || $password === '') {
            return redirect()->back()->with('error', 'Nomor HP dan password wajib diisi.');
        }

        if (!preg_match('/^08\d{10,11}$/', $no_hp)) {
            return redirect()->back()->with('error', 'Nomor HP tidak valid.');
        }

        $users = new UserModel();
        $user  = $users->where('no_hp', $no_hp)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Akun tidak ditemukan.');
        }

        if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        /* =====================================
     * ✅ AUTO VERIFIKASI LOGIN PERTAMA
     * ===================================== */
        if ((int)($user['wa_verified'] ?? 0) !== 1) {
            db_connect()->table('users')
                ->where('id', $user['id'])
                ->update([
                    'wa_verified'    => 1,
                    'wa_verified_at' => date('Y-m-d H:i:s')
                ]);

            $user['wa_verified'] = 1;
        }

        /* ROLE */
        $roleName = 'pembeli';
        if (!empty($user['role_id'])) {
            $roleRow = db_connect()
                ->table('roles')
                ->where('id', $user['role_id'])
                ->get()
                ->getRowArray();

            $roleName = $roleRow['name'] ?? 'pembeli';
        }

        session()->regenerate();
        session()->set('user', [
            'id'          => (int) $user['id'],
            'name'        => $user['name'],
            'no_hp'       => $user['no_hp'],
            'role'        => $roleName,
            'wa_verified' => 1,
            'logged_in'   => true,
        ]);

        session()->setFlashdata(
            'welcome',
            'Halo, ' . explode(' ', $user['name'])[0] . '! Selamat datang 👋'
        );

        return $roleName === 'admin'
            ? redirect()->to('/admin/menus')
            : redirect()->to('/');
    }
    
    /* =========================
     * LOGOUT
     * ========================= */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }

    /* =========================
     * REGISTER
     * ========================= */
    public function attemptRegister()
    {
        $users = new UserModel();

        $name    = trim($this->request->getPost('name'));
        $no_hp   = trim($this->request->getPost('no_hp'));
        $pass    = $this->request->getPost('password');
        $confirm = $this->request->getPost('password_confirm');

        if ($name === '' || $no_hp === '' || $pass === '') {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        if (!preg_match('/^08\d{10,11}$/', $no_hp)) {
            return redirect()->back()->with('error', 'Nomor HP tidak valid.');
        }

        if ($pass !== $confirm) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak sama.');
        }

        if ($users->where('no_hp', $no_hp)->first()) {
            return redirect()->back()->with('error', 'Nomor HP sudah terdaftar.');
        }

        $role = db_connect()
            ->table('roles')
            ->where('name', 'pembeli')
            ->get()
            ->getRowArray();

        $users->insert([
            'role_id'       => $role['id'],
            'name'          => $name,
            'no_hp'         => $no_hp,
            'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
            'wa_verified'   => 0,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        /* POPUP VERIFIKASI WA */
        return redirect()->back()->with('verify_popup', [
            'name'  => $name,
            'no_hp' => $no_hp
        ]);
    }
}
