<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserAuth implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($session->get('role') !== 'user') {
            return redirect()->to(base_url('/admin'))->with('error', 'Anda tidak diizinkan mengakses halaman ini.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
