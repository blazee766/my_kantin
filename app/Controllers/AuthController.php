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

    /* ---------- AUTH: LOGIN (email ATAU npm) ---------- */
    public function attempt()
    {
        $email    = trim((string) $this->request->getPost('email'));
        $npm      = trim((string) $this->request->getPost('npm'));
        $password = (string) $this->request->getPost('password');

        $users = new UserModel();

        // Tentukan mode login: prioritas email, fallback ke npm
        if ($email !== '') {
            $user = $users->where('email', $email)->first();
            $pwdHashField = 'password';        // versi model yang menyimpan kolom "password"
        } else {
            $user = $users->where('npm', $npm)->first();
            $pwdHashField = 'password_hash';   // versi model yang menyimpan kolom "password_hash"
        }

        // Validasi user & password
        $hash = $user[$pwdHashField] ?? null;
        if (!$user || !$hash || !password_verify($password, $hash)) {
            return redirect()->back()
                ->with('error', ($email ? 'Email' : 'NPM') . ' atau password salah.')
                ->withInput();
        }

        // Jika ada flag is_active
        if (array_key_exists('is_active', $user) && !(int) $user['is_active']) {
            return redirect()->back()->with('error', 'Akun nonaktif.')->withInput();
        }

        // Ambil nama role dari tabel roles (jika ada role_id)
        $roleName = 'pembeli';
        if (!empty($user['role_id'])) {
            $roleRow  = db_connect()->table('roles')->where('id', $user['role_id'])->get()->getRowArray();
            $roleName = $roleRow['name'] ?? 'pembeli';
        } elseif (!empty($user['role'])) {
            $roleName = $user['role']; // fallback jika tabel roles tidak dipakai
        }

        // --- KEAMANAN SESSION ---
        session()->regenerate(); // cegah session fixation

        $safeUser = [
            'id'        => (int) ($user['id'] ?? 0),
            'name'      => esc($user['name'] ?? ''),
            'npm'       => esc($user['npm'] ?? ''),
            'email'     => esc($user['email'] ?? ''),
            'role'      => esc($roleName),
            // alamat kampus (opsional)
            'building'  => esc($user['building'] ?? ''),
            'room'      => esc($user['room'] ?? ''),
            'note'      => esc($user['note'] ?? ''),
            'logged_in' => true,
            'last_login'=> date('Y-m-d H:i:s'),
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

        // ambil id role "pembeli" bila ada tabel roles
        $roles = db_connect()->table('roles')->where('name', 'pembeli')->get()->getRowArray();

        $name     = trim((string) $this->request->getPost('name'));
        $npm      = trim((string) $this->request->getPost('npm'));
        $email    = trim((string) $this->request->getPost('email')); // opsional
        $pass     = (string) $this->request->getPost('password');
        $confirm  = (string) $this->request->getPost('password_confirm');

        // ---- Validasi ringkas & jelas ----
        if ($name === '' || $npm === '' || $pass === '') {
            return redirect()->back()->with('error', 'Nama, NPM, dan password wajib diisi.')->withInput();
        }
        if (!preg_match('/^\d{10}$/', $npm)) {
            return redirect()->back()->with('error', 'NPM harus 10 digit angka.')->withInput();
        }
        if ($pass !== $confirm) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak sama.')->withInput();
        }
        if ($users->where('npm', $npm)->first()) {
            return redirect()->back()->with('error', 'NPM sudah terdaftar.')->withInput();
        }
        if ($email && $users->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Email sudah terdaftar.')->withInput();
        }

        // ---- Simpan user baru ----
        $data = [
            'role_id'       => $roles['id'] ?? null,
            'role'          => $roles['id'] ? null : 'pembeli', // fallback bila tidak pakai tabel roles
            'name'          => $name,
            'npm'           => $npm,
            'email'         => $email ?: null,
            'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        // Jika model kamu hanya punya kolom "password", bukan "password_hash", set keduanya aman:
        if (property_exists($users, 'allowedFields')) {
            if (in_array('password', $users->allowedFields) && !in_array('password_hash', $users->allowedFields)) {
                $data['password'] = $data['password_hash'];
                unset($data['password_hash']);
            }
        }

        $users->insert($data);

        return redirect()->to('/register/success')
            ->with('success', 'Pendaftaran berhasil! Silakan masuk untuk melanjutkan.');
    }
}
