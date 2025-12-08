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
    /*
    public function registerSuccess()
    {
        return view('auth/register_success');
    }
    */
    public function attempt()
    {
        $email    = trim((string) $this->request->getPost('email'));
        $no_hp    = trim((string) $this->request->getPost('no_hp'));
        $password = (string) $this->request->getPost('password');

        if ($email === '') {
            if ($no_hp === '' || !preg_match('/^08[0-9]{10}$/', $no_hp)) {
                return redirect()->back()
                    ->with('error', 'Nomor HP tidak valid. Gunakan nomor HP yang diawali 08 dan terdiri dari 12 digit angka.')
                    ->withInput();
            }
        }

        $users = new UserModel();

        if ($email !== '') {
            $user = $users->where('email', $email)->first();
        } else {
            $user = $users->where('no_hp', $no_hp)->first();
        }

        if (array_key_exists('is_active', $user) && !(int) $user['is_active']) {
            return redirect()->back()->with('error', 'Akun nonaktif.')->withInput();
        }

        $roleName = 'pembeli';
        if (!empty($user['role_id'])) {
            $roleRow  = db_connect()
                ->table('roles')
                ->where('id', $user['role_id'])
                ->get()
                ->getRowArray();

            $roleName = $roleRow['name'] ?? 'pembeli';
        }

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

        $first = trim(explode(' ', $safeUser['name'])[0] ?? $safeUser['name']);
        session()->setFlashdata('welcome', "Halo, {$first}! Selamat datang di Kantin G'penk 🎉");

        if ($roleName === 'admin') {
            return redirect()->to('/admin/menus');
        }
        return redirect()->to('/');
    }

    public function logout()
    {
        session()->remove('user');
        session()->destroy();
        return redirect()->to('/')->with('success', 'Berhasil logout.');
    }

    public function attemptRegister()
    {
        $users = new UserModel();

        $roles = db_connect()
            ->table('roles')
            ->where('name', 'pembeli')
            ->get()
            ->getRowArray();

        $name    = trim((string) $this->request->getPost('name'));
        $no_hp   = trim((string) $this->request->getPost('no_hp'));
        $email   = trim((string) $this->request->getPost('email')); 
        $pass    = (string) $this->request->getPost('password');
        $confirm = (string) $this->request->getPost('password_confirm');

        if ($name === '' || $no_hp === '' || $pass === '') {
            return redirect()->back()
                ->with('error', 'Nama, Nomor HP, dan password wajib diisi.')
                ->withInput();
        }

        if (!preg_match('/^08[0-9]{10}$/', $no_hp)) {
            return redirect()->back()
                ->with('error', 'Nomor HP harus diawali 08 dan terdiri dari 12 digit angka.')
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

        $data = [
            'role_id'       => $roles['id'] ?? null,
            'name'          => $name,
            'no_hp'         => $no_hp,
            'email'         => $email ?: null,
            'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        $users->insert($data);

        session()->setFlashdata('success', 'Pendaftaran berhasil! Silakan masuk untuk melanjutkan.');
        return redirect()->to('/register');
    }
}
