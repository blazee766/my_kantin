<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    /* ---------- VIEWS ---------- */
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerSuccess()
    {
        return view('auth/register_success');
    }

    /* ---------- AUTH: LOGIN (email ATAU no_hp) ---------- */
    public function attempt()
    {
        $email    = trim((string) $this->request->getPost('email'));
        $no_hp    = trim((string) $this->request->getPost('no_hp'));
        $password = (string) $this->request->getPost('password');

        $users = new UserModel();

        // Mode login: kalau email diisi, pakai email; kalau tidak, pakai no_hp
        if ($email !== '') {
            $user = $users->where('email', $email)->first();
        } else {
            $user = $users->where('no_hp', $no_hp)->first();
        }

        // Validasi user & password (selalu pakai kolom password_hash)
        $hash = $user['password_hash'] ?? null;
        if (!$user || !$hash || !password_verify($password, $hash)) {
            return redirect()->back()
                ->with('error', ($email ? 'Email' : 'Nomor HP') . ' atau password salah.')
                ->withInput();
        }

        // Jika ada flag is_active
        if (array_key_exists('is_active', $user) && !(int) $user['is_active']) {
            return redirect()->back()->with('error', 'Akun nonaktif.')->withInput();
        }

        // Ambil nama role dari tabel roles (via role_id)
        $roleName = 'pembeli';
        if (!empty($user['role_id'])) {
            $roleRow  = db_connect()
                ->table('roles')
                ->where('id', $user['role_id'])
                ->get()
                ->getRowArray();

            $roleName = $roleRow['name'] ?? 'pembeli';
        }

        // --- KEAMANAN SESSION ---
        session()->regenerate();

        $safeUser = [
            'id'         => (int) ($user['id'] ?? 0),
            'name'       => esc($user['name'] ?? ''),
            'no_hp'      => esc($user['no_hp'] ?? ''),
            'email'      => esc($user['email'] ?? ''),
            'role'       => esc($roleName),
            'logged_in'  => true,
            'last_login' => date('Y-m-d H:i:s'),
        ];
        session()->set('user', $safeUser);

        // salam sambutan
        $first = trim(explode(' ', $safeUser['name'])[0] ?? $safeUser['name']);
        session()->setFlashdata('welcome', "Halo, {$first}! Selamat datang di KantinKamu 🎉");

        // arahkan per role
        if ($roleName === 'admin') {
            return redirect()->to('/admin/menus');
        }
        return redirect()->to('/');
    }

    /* ---------- AUTH: LOGOUT ---------- */
    public function logout()
    {
        session()->remove('user');
        session()->destroy();
        return redirect()->to('/')->with('success', 'Berhasil logout.');
    }

    /* ---------- REGISTER ---------- */
    public function attemptRegister()
    {
        $users = new UserModel();

        // ambil id role "pembeli" bila ada di tabel roles
        $roles = db_connect()
            ->table('roles')
            ->where('name', 'pembeli')
            ->get()
            ->getRowArray();

        $name    = trim((string) $this->request->getPost('name'));
        $no_hp   = trim((string) $this->request->getPost('no_hp'));
        $email   = trim((string) $this->request->getPost('email')); // opsional
        $pass    = (string) $this->request->getPost('password');
        $confirm = (string) $this->request->getPost('password_confirm');

        // ---- Validasi ----
        if ($name === '' || $no_hp === '' || $pass === '') {
            return redirect()->back()
                ->with('error', 'Nama, Nomor HP, dan password wajib diisi.')
                ->withInput();
        }

        // 12 digit angka (disesuaikan dengan kolom VARCHAR(12))
        if (!preg_match('/^\d{12}$/', $no_hp)) {
            return redirect()->back()
                ->with('error', 'Nomor HP harus 12 digit angka.')
                ->withInput();
        }

        if ($pass !== $confirm) {
            return redirect()->back()
                ->with('error', 'Konfirmasi password tidak sama.')
                ->withInput();
        }

        if ($users->where('no_hp', $no_hp)->first()) {
            return redirect()->back()
                ->with('error', 'Nomor HP sudah terdaftar.')
                ->withInput();
        }

        if ($email && $users->where('email', $email)->first()) {
            return redirect()->back()
                ->with('error', 'Email sudah terdaftar.')
                ->withInput();
        }

        // ---- Simpan user baru ----
        $data = [
            'role_id'       => $roles['id'] ?? null,
            'name'          => $name,
            'no_hp'         => $no_hp,
            'email'         => $email ?: null,
            'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        $users->insert($data);

        return redirect()->to('/register/success')
            ->with('success', 'Pendaftaran berhasil! Silakan masuk untuk melanjutkan.');
    }
}
