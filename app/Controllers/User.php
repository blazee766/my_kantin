<?php

namespace App\Controllers;

use App\Models\UserAddressModel;

class User extends BaseController
{
    public function update_address()
    {
        $user = session('user');
        $userId = (int) ($user['id'] ?? 0);

        if ($userId <= 0) {
            return redirect()->to('/login');
        }

        $building = trim((string) $this->request->getPost('building'));
        $room = trim((string) $this->request->getPost('room'));
        $note = trim((string) $this->request->getPost('note'));

        if ($building === '' || $room === '') {
            return redirect()->back()
                ->with('error', 'Isi gedung dan ruangan terlebih dahulu.');
        }

        $addresses = model(UserAddressModel::class);
        $existing = $addresses
            ->where('user_id', $userId)
            ->where('is_default', 1)
            ->first();

        $data = [
            'user_id' => $userId,
            'building' => $building,
            'room' => $room,
            'note' => $note,
            'is_default' => 1,
        ];

        if ($existing) {
            $addresses->update((int) $existing['id'], $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $addresses->insert($data);
        }

        session()->set('user.building', $building);
        session()->set('user.room', $room);
        session()->set('user.note', $note);

        return redirect()->back()
            ->with('success', 'Alamat kampus berhasil diperbarui.');
    }
}
