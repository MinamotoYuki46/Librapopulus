<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController {

    protected $userModel;
    
    public function __construct() {
        $this -> userModel = new UserModel();
    }
    
    public function index()    {
        $this->destroyRegisterSession();
        return redirect() -> to(base_url('auth/login'));
    }
    
    public function login() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }
        
        $this->destroyRegisterSession();
        return view('auth/login');
    }
    
    public function register() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }
        
        $this->destroyRegisterSession();
        
        return view('auth/register');
    }

    public function detail() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }
        
        return view('auth/detail');
    }

    public function success() {
        if (session() -> get('isLoggedIn')) {
            return redirect() -> to(base_url('dashboard'));
        }
        
        return view('auth/success');
    }
    
    public function processLogin() {
        // TODO
        $session = session();
        $identity = $this->request->getPost('identity'); 
        $password = $this->request->getPost('password');

        $user = $this->userModel
        ->groupStart()
            ->where('username', $identity)
            ->orWhere('email', $identity)
        ->groupEnd()
        ->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'isLoggedIn' => true,
                'user_id'    => $user['id'], 
                'username'   => $user['username']
            ]);

            return redirect()-> to(base_url());
        } else {

            return redirect()->back()->with('error', 'Username/email atau password salah!');
        }
    }
    
    public function processRegister() {
       // TODO
    }
    
    public function logout() {
        session() -> destroy();
        
        return redirect() -> to(base_url());
    }

    private function destroyRegisterSession(){
        if(session()->has('register_data')) {
            session()->remove('register_data');
        }
    }
}