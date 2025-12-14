<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class VerifiedFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = session('user');

        if (!$user || ($user['wa_verified'] ?? 0) !== 1) {
            return redirect()->to('/login')
                ->with('error', 'Silakan verifikasi WhatsApp terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
