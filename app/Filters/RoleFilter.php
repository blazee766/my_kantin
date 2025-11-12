<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $user = $session->get('user');
        if (!$user) {
            return redirect()->to('/login')->with('error','Silakan login dulu.');
        }
        if ($arguments && count($arguments) > 0) {
            $allowed = $arguments; // ['admin'] or ['pembeli']
            if (!in_array($user['role'], $allowed)) {
                return redirect()->to('/')->with('error','Akses ditolak.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
