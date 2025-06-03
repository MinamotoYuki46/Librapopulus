<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use Config\Services;

class AuthCheck implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/welcome');
        }

        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        
    }
}
